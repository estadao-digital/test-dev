<!-- START_<?php echo e($parsedRoute['id']); ?> -->
<?php if($parsedRoute['title'] != ''): ?>## <?php echo e($parsedRoute['title']); ?>

<?php else: ?>## <?php echo e($parsedRoute['uri']); ?>

<?php endif; ?>
<?php if($parsedRoute['description']): ?>

<?php echo $parsedRoute['description']; ?>

<?php endif; ?>

> Example request:

```bash
curl -X <?php echo e($parsedRoute['methods'][0]); ?> "<?php echo e(config('app.docs_url') ?: config('app.url')); ?>/<?php echo e($parsedRoute['uri']); ?>" \
-H "Accept: application/json"<?php if(count($parsedRoute['parameters'])): ?> \
<?php $__currentLoopData = $parsedRoute['parameters']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute => $parameter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    -d "<?php echo e($attribute); ?>"="<?php echo e($parameter['value']); ?>" \
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "<?php echo e(config('app.docs_url') ?: config('app.url')); ?>/<?php echo e($parsedRoute['uri']); ?>",
    "method": "<?php echo e($parsedRoute['methods'][0]); ?>",
    <?php if(count($parsedRoute['parameters'])): ?>
"data": <?php echo str_replace('    ','        ',json_encode(array_combine(array_keys($parsedRoute['parameters']), array_map(function($param){ return $param['value']; },$parsedRoute['parameters'])), JSON_PRETTY_PRINT)); ?>,
    <?php endif; ?>
"headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

<?php if(in_array('GET',$parsedRoute['methods']) || isset($parsedRoute['showresponse']) && $parsedRoute['showresponse']): ?>
> Example response:

```json
<?php if(is_object($parsedRoute['response']) || is_array($parsedRoute['response'])): ?>
<?php echo json_encode($parsedRoute['response'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?>

<?php else: ?>
<?php echo json_encode(json_decode($parsedRoute['response']), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?>

<?php endif; ?>
```
<?php endif; ?>

### HTTP Request
<?php $__currentLoopData = $parsedRoute['methods']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
`<?php echo e($method); ?> <?php echo e($parsedRoute['uri']); ?>`

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if(count($parsedRoute['parameters'])): ?>
#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
<?php $__currentLoopData = $parsedRoute['parameters']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute => $parameter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo e($attribute); ?> | <?php echo e($parameter['type']); ?> | <?php if($parameter['required']): ?> required <?php else: ?> optional <?php endif; ?> | <?php echo implode(' ',$parameter['description']); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<!-- END_<?php echo e($parsedRoute['id']); ?> -->
