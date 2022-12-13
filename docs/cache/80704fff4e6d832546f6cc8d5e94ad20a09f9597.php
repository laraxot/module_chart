
 
<?php $__env->startSection('body'); ?>
    <h1>Doc Posts</h1>
    
    <?php $__currentLoopData = $docs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <h2><a href="<?php echo e($post->getPath()); ?>"><?php echo e($post->title); ?></a></h2>
        <h3>By <?php echo e($post->author); ?></h3>
        <?php echo e($post->getContent()); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('_layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\var\www\_bases\base_ptvx\laravel\Modules\Chart\docs/source\docs.blade.php ENDPATH**/ ?>