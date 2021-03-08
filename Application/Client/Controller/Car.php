<?php

namespace Application\Client\Controller
{
    use Application\Client\Component;

    class Car
    {
        protected static $cacheData         = null;
        protected static $brands            = null;
        protected static $carWrapper        = null;
        protected static $carModalWrapper   = null;
        protected static $carHtml           = null;
        protected static $carModalHtml      = null;
        protected static $currentAction     = null;
        protected static $currentCarId      = null;
        protected static $currentModal      = null;
        protected static $currentAnimation  = null;

        public static function onRequest($data)
        {
            self::$cacheData        = $data;
            self::$currentAnimation = 0;

            self::$carWrapper      = \Element::find('[data-wrapper=\'car\']');
            self::$carModalWrapper = \Element::find('[data-wrapper=\'car-modal\']');

            self::$carHtml         = \Render\Front\Template::getBySid('car');
            self::$carModalHtml    = \Render\Front\Template::getBySid('car-modal');

            // Hook buttons
            $carAddButton = \Element::find('[data-button=\'car-add\']');
            if ($carAddButton !== null) {
                $carAddButton->event->onClick(function($event) {
                    self::onButtonAdd();
                });
            }

            $carEditButtons = \Elements::find('[data-button=\'car-edit\']');
            if ($carEditButtons !== null) {
                foreach ($carEditButtons->elements as $carEditButton) {
                    $carEditButton->event->onClick(function($event) {
                        $carId = toInt($event->target->get('data-carid'));
                        self::onButtonEdit($carId);
                    });
                }
            }

            \FunctionEx::delay(function() {
                self::loadAnimation();
            }, 100);
        }

        protected static function loadAnimation()
        {
            if (self::$cacheData->cars->containsKey(self::$currentAnimation) === false)
                return;

            \Element::find('[data-wrapper=\'car\'] [data-carid=\'' . self::$cacheData->cars[self::$currentAnimation]->carId . '\']')->style->set('opacity', 1);
            self::$currentAnimation++;

            \FunctionEx::delay(function() {
                self::loadAnimation();
            }, 100);
        }

        // Inject modal events
        protected static function hookModal()
        {
            // Hook buttons
            $carModal = \Element::find('[data-button=\'car-modal\']');
            if ($carModal !== null) {
                $carModal->event->onClick(function($event) {
                    if (self::$currentAction === 'add')
                        self::onAdd();
                    else self::onEdit();
                });
            }

            $carRemove = \Element::find('[data-button=\'car-remove\']');
            if ($carRemove !== null) {
                $carRemove->event->onClick(function($event) {
                    self::onRemove();
                });
            }

            // Block year 4 digits
            $inputCarYear = \Element::find('[data-input=\'car-year\']');
            if ($inputCarYear !== null) {
                $inputCarYear->event->onInput(function($event) {
                    $year = toString($event->target->value);
                    if ($year->length > 4)
                        $event->target->value = $year->subString(0, 4);
                });
            }

            self::$currentModal = \Element::find('[data-modal=\'car\']');
        }

        protected static function onButtonAdd()
        {
            self::$currentAction = 'add';

            // Check if brands is already loaded
            if (self::$brands === null) {
                self::getBrands();
                return;
            }

            // Render add modal
            $renderData = Arr();
            $renderData->brands = self::$brands;

            $renderHtml = \Render\Front::renderHTML(self::$carModalHtml, $renderData);
            self::$carModalWrapper->html = $renderHtml;
            self::hookModal();

            self::$currentModal->jQuery->modal('show');
        }

        protected static function onButtonEdit($carId)
        {
            self::$currentAction = 'edit';
            self::$currentCarId  = $carId;

            // Check if brands is already loaded
            if (self::$brands === null) {
                self::getBrands();
                return;
            }

            // Get car data request
            $request = new \Http\Request('/api/car/' . $carId);
            $request->method   = 'get';
            $request->dataType = 'json';

            Component\Loader::show();

            $request->send(function($data) {
                Component\Loader::hide();

                if ($data->containsKey('error') && $data->error !== null) {
                    self::error($data->error);
                    return false;
                }

                $data->brands = self::$brands;

                // Render edit modal
                $renderHtml = \Render\Front::renderHTML(self::$carModalHtml, $data);
                self::$carModalWrapper->html = $renderHtml;
                self::hookModal();

                self::$currentModal->jQuery->modal('show');

                return false;
            });

        }

        // Get brands data
        protected static function getBrands()
        {
            $request = new \Http\Request('/api/car/brand');
            $request->method   = 'get';
            $request->dataType = 'json';

            Component\Loader::show();

            $request->send(function($data) {
                Component\Loader::hide();

                if ($data->containsKey('error') && $data->error !== null) {
                    self::error($data->error);
                    return false;
                }

                // Callbacks
                self::$brands = $data->brands;
                if (self::$currentAction === 'add') {
                    self::onButtonAdd();
                    return false;
                }
                elseif (self::$currentAction === 'edit') {
                    self::onButtonEdit(self::$currentCarId);
                    return false;
                }

                return false;
            });
        }

        protected static function onAdd()
        {
            $request = new \Http\Request('/api/car/add');
            $request->method   = 'post';
            $request->dataType = 'json';

            $request->data = self::getForm();
            Component\Loader::show();

            $request->send(function($data) {
                Component\Loader::hide();

                if ($data->containsKey('error') && $data->error !== null) {
                    self::error($data->error);
                    return false;
                }

                \Swal::fire(['title' => 'Carro adicionado com sucesso.', 'icon' => 'success', 'showConfirmButton' => true]);
                self::$currentModal->jQuery->modal('hide');

                // Render new car
                $renderData = Arr();
                $renderData->car = $data;

                $renderHtml = \Render\Front::renderHTML(self::$carHtml, $data);
                self::$carWrapper->appendHTML($renderHtml);

                \Element::find('[data-wrapper=\'car\'] [data-carid=\'' .$data->car->carId . '\']')->style->set('opacity', 1);

                // Hook single edit button
                $carEditButton = \Element::find('[data-button=\'car-edit\'][data-carid=\'' . $data->car->carId . '\']');

                if ($carEditButton !== null) {
                    $carEditButton->event->onClick(function($event) {
                        $carId = toInt($event->target->get('data-carid'));
                        self::onButtonEdit($carId);
                    });
                }

                \FunctionEx::delay(function() {

                }, 1000);

                return false;
            });
        }

        protected static function onEdit()
        {
            $request = new \Http\Request('/api/car/' . self::$currentCarId);
            $request->method   = 'post';
            $request->dataType = 'json';

            $request->data = self::getForm();
            Component\Loader::show();

            $request->send(function($data) {
                Component\Loader::hide();

                if ($data->containsKey('error') && $data->error !== null) {
                    self::error($data->error);
                    return false;
                }

                self::$currentModal->jQuery->modal('hide');
                \Swal::fire(['title' => 'Carro editado com sucesso.', 'icon' => 'success', 'showConfirmButton' => true]);

                // Update car html
                $baseSelect = '[data-wrapper=\'car\'] [data-carid=\'' . $data->car->carId . '\'] ';
                \Element::find($baseSelect . '[data-wrapper=\'car-brand\']')->html = $data->car->brand;
                \Element::find($baseSelect . '[data-wrapper=\'car-model\']')->html = $data->car->model;
                \Element::find($baseSelect . '[data-wrapper=\'car-year\']')->html  = $data->car->year;

                return false;
            });
        }

        protected static function onRemove()
        {
            $request = new \Http\Request('/api/car/' . self::$currentCarId);
            $request->method   = 'delete';
            $request->dataType = 'json';

            Component\Loader::show();

            $request->send(function($data) {
                Component\Loader::hide();

                if ($data->containsKey('error') && $data->error !== null) {
                    self::error($data->error);
                    return false;
                }

                self::$currentModal->jQuery->modal('hide');
                \Swal::fire(['title' => 'Carro removido com sucesso.', 'icon' => 'success', 'showConfirmButton' => true]);

                // Remove from list
                $carWrapper = \Element::find('[data-wrapper=\'car\'] [data-carid=\'' .$data->car->carId . '\']');
                $carWrapper->class->add('delete');
                $carWrapper->style->set('color', '#e31d2d');
                $carWrapper->style->set('opacity', 0);

                \FunctionEx::delay(function() {
                    \Element::find('[data-wrapper=\'car\'] [data-carid=\'' . self::$currentCarId . '\']')->destroy();
                }, 1000);

                return false;
            });
        }

        // Return values from form
        protected static function getForm()
        {
            $data = Arr();
            $data->brandId  = \Element::find('[data-input=\'car-brandid\']')->value;
            $data->model    = \Element::find('[data-input=\'car-model\']')->value;
            $data->year     = \Element::find('[data-input=\'car-year\']')->value;

            return $data;
        }

        // Show errors by ERROR SID
        protected static function error($error)
        {
            Component\Loader::hide();

            if ($error === 'INVALID_CAR_ID')
                \Swal::fire(['title' => 'Carro não existe ou foi removido.', 'icon' => 'error']);
            elseif ($error === 'INVALID_BRAND_ID')
                \Swal::fire(['title' => 'Marca não selecionada.', 'icon' => 'error']);
            elseif ($error === 'INVALID_MODEL')
                \Swal::fire(['title' => 'Modelo vazio.', 'icon' => 'error']);
            elseif ($error === 'INVALID_YEAR')
                \Swal::fire(['title' => 'Ano vazio ou inválido.', 'icon' => 'error']);
            else \Swal::fire(['title' => 'Erro interno do servidor. Por favor, tente novamente mais tarde.', 'icon' => 'error']);
        }
    }
}

