<?php $__env->startSection('body'); ?>
<section class="container max-w-6xl mx-auto px-6 py-10 md:py-12">
    <div class="flex flex-col-reverse mb-10 lg:flex-row lg:mb-24">
        <div class="mt-8">
            <h1 id="intro-docs-template"><?php echo e($page->siteName); ?></h1>

            <h2 id="intro-powered-by-jigsaw" class="font-light mt-4"><?php echo e($page->siteDescription); ?></h2>

            <p class="text-lg">Give your documentation a boost with Jigsaw. <br class="hidden sm:block">Generate elegant, static docs quickly and easily.</p>
            ----------------
            <br/>Url: <?php echo e(url('/')); ?>

            <?php $__currentLoopData = $docs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>            
                <h2><a href="<?php echo e(url($doc->getPath())); ?>"><?php echo e($doc->title); ?></a>
                    <br/>getPath: <?php echo e($doc->getPath()); ?>

                    <br/>url getPath: <?php echo e(url($doc->getPath())); ?>

                    <br/>doc url: <?php echo e($doc->url()); ?>

                </h2>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ------------------

            <div class="flex my-10">
                <a href="/docs/getting-started" title="<?php echo e($page->siteName); ?> getting started" class="bg-blue-500 hover:bg-blue-600 font-normal text-white hover:text-white rounded mr-4 py-2 px-6">Get Started</a>

                <a href="https://jigsaw.tighten.co" title="Jigsaw by Tighten" class="bg-gray-400 hover:bg-gray-600 text-blue-900 font-normal hover:text-white rounded py-2 px-6">About Jigsaw</a>
            </div>
        </div>

        <img src="/assets/img/logo-large.svg" alt="<?php echo e($page->siteName); ?> large logo" class="mx-auto mb-6 lg:mb-0 ">
    </div>

    <hr class="block my-8 border lg:hidden">

    <div class="md:flex -mx-2 -mx-4">
        <div class="mb-8 mx-3 px-2 md:w-1/3">
            <img src="/assets/img/icon-window.svg" class="h-12 w-12" alt="window icon">

            <h3 id="intro-laravel" class="text-2xl text-blue-900 mb-0">Templating with <br>Laravel's Blade engine</h3>

            <p>Blade is a powerful, simple, and beautiful templating language, and now you can use it for your static sites, not just your Laravel-powered apps.</p>
        </div>

        <div class="mb-8 mx-3 px-2 md:w-1/3">
            <img src="/assets/img/icon-terminal.svg" class="h-12 w-12" alt="terminal icon">

            <h3 id="intro-markdown" class="text-2xl text-blue-900 mb-0">Use Markdown for <br>content-driven pages</h3>

            <p>Markdown is the web’s leading format for writing articles, blog posts, documentation, and more. Jigsaw makes it painless to work with Markdown content.</p>
        </div>

        <div class="mx-3 px-2 md:w-1/3">
            <img src="/assets/img/icon-stack.svg" class="h-12 w-12" alt="stack icon">

            <h3 id="intro-mix" class="text-2xl text-blue-900 mb-0">Compile your assets <br>using Laravel Mix </h3>

            <p>Jigsaw comes pre-configured with Laravel Mix, a simple and powerful build tool. Use the latest frontend tech with just a few lines of code.</p>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('_layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\var\www\_bases\base_ptvx\laravel\Modules\Chart\docs/source\index.blade.php ENDPATH**/ ?>