<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
// use Cake\Auth\DefaultPasswordHasher;

/**
 * Carro Entity
 *
 * @property int $id
 * @property string $marca
 * @property string $modelo
 * @property \Cake\I18n\FrozenDate $ano
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Carro extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'marca' => true,
        'modelo' => true,
        'ano' => true,
        'created' => true,
        'modified' => true
    ];
}
