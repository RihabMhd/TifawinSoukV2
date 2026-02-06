                    
                    <script src="https://cdn.tailwindcss.com"></script>
                    <?php $__currentLoopData = $product_rupture; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <p class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                      title :  <?php echo e($product->title); ?> 
                                    </div>
                                </p>
                                <p class="px-6 py-4">
                                    <div class="text-sm text-gray-700 dark:text-gray-300 max-w-xs truncate">
                                     description :   <?php echo e($product->description ?? 'No description'); ?>

                                    </div>
                                </p>
                                <p class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                      price :  <?php echo e($product->price); ?> 
                                    </span>
                                </p>
                                <p class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700 dark:text-gray-300">
                                      quantity :  <?php echo e($product->quantity); ?>

                                    </div>
                                </p>
                                <p class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                </p>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $product_stock_critique; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="hover:bg-red-50 dark:hover:bg-red-700">
                                <p class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                      title :  <?php echo e($product->title); ?> 
                                    </div>
                                </p>
                                <p class="px-6 py-4">
                                    <div class="text-sm text-gray-700 dark:text-gray-300 max-w-xs truncate">
                                     description :   <?php echo e($product->description ?? 'No description'); ?>

                                    </div>
                                </p>
                                <p class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                      price :  <?php echo e($product->price); ?> 
                                    </span>
                                </p>
                                <p class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700 dark:text-gray-300">
                                      quantity :  <?php echo e($product->quantity); ?>

                                    </div>
                                </p>
                                <p class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                </p>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="hover:bg-red-50 dark:hover:bg-red-700">
                                <p class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                      total :  <?php echo e($product_valeur_inventaire); ?> 
                                    </div>
                                </p>
                              
                            </div>
<?php /**PATH C:\laragon\www\TifawinSoukV2\resources\views/admin/stocks/dashboard.blade.php ENDPATH**/ ?>