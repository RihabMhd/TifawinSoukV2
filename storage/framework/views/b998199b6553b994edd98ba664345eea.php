<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <?php echo e(__('Finaliser la commande')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Messages de succès/erreur -->
            <?php if(session('success')): ?>
                <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                    <p class="text-sm text-green-800 dark:text-green-200">
                        <?php echo e(session('success')); ?>

                    </p>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="mb-4 px-4 py-3 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                    <p class="text-sm text-red-800 dark:text-red-200">
                        <?php echo e(session('error')); ?>

                    </p>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="mb-4 px-4 py-3 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                    <ul class="list-disc list-inside text-sm text-red-800 dark:text-red-200">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('checkout.process')); ?>" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <?php echo csrf_field(); ?>

                <!-- Formulaire de commande -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Informations de livraison -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Informations de livraison
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Prénom -->
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Prénom <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="first_name" 
                                       id="first_name" 
                                       value="<?php echo e(old('first_name', auth()->user()->first_name ?? '')); ?>"
                                       required
                                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Nom -->
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nom <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="last_name" 
                                       id="last_name" 
                                       value="<?php echo e(old('last_name', auth()->user()->last_name ?? '')); ?>"
                                       required
                                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="<?php echo e(old('email', auth()->user()->email)); ?>"
                                       required
                                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Téléphone -->
                            <div class="md:col-span-2">
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Téléphone <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" 
                                       name="phone" 
                                       id="phone" 
                                       value="<?php echo e(old('phone', auth()->user()->phone ?? '')); ?>"
                                       required
                                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Adresse -->
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Adresse <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="address" 
                                       id="address" 
                                       value="<?php echo e(old('address')); ?>"
                                       required
                                       placeholder="Numéro et nom de rue"
                                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Complément d'adresse -->
                            <div class="md:col-span-2">
                                <label for="address_complement" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Complément d'adresse
                                </label>
                                <input type="text" 
                                       name="address_complement" 
                                       id="address_complement" 
                                       value="<?php echo e(old('address_complement')); ?>"
                                       placeholder="Appartement, étage, bâtiment..."
                                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Code postal -->
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Code postal <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="postal_code" 
                                       id="postal_code" 
                                       value="<?php echo e(old('postal_code')); ?>"
                                       required
                                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Ville -->
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Ville <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="city" 
                                       id="city" 
                                       value="<?php echo e(old('city')); ?>"
                                       required
                                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Pays -->
                            <div class="md:col-span-2">
                                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Pays <span class="text-red-500">*</span>
                                </label>
                                <select name="country" 
                                        id="country" 
                                        required
                                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Sélectionnez un pays</option>
                                    <option value="FR" <?php echo e(old('country') == 'FR' ? 'selected' : ''); ?>>France</option>
                                    <option value="BE" <?php echo e(old('country') == 'BE' ? 'selected' : ''); ?>>Belgique</option>
                                    <option value="CH" <?php echo e(old('country') == 'CH' ? 'selected' : ''); ?>>Suisse</option>
                                    <option value="CA" <?php echo e(old('country') == 'CA' ? 'selected' : ''); ?>>Canada</option>
                                    <option value="MA" <?php echo e(old('country') == 'MA' ? 'selected' : ''); ?>>Maroc</option>
                                    <option value="US" <?php echo e(old('country') == 'US' ? 'selected' : ''); ?>>États-Unis</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Méthode de paiement -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Méthode de paiement
                        </h3>

                        <div class="space-y-3">
                            <!-- Carte bancaire -->
                            <label class="flex items-center p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="credit_card" 
                                       checked
                                       class="mr-3 text-blue-600 focus:ring-blue-500">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">Carte bancaire</span>
                                </div>
                            </label>

                            <!-- PayPal -->
                            <label class="flex items-center p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="paypal"
                                       class="mr-3 text-blue-600 focus:ring-blue-500">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.067 8.478c.492.88.556 2.014.3 3.327-.74 3.806-3.276 5.12-6.514 5.12h-.5a.805.805 0 00-.794.68l-.04.22-.63 3.993-.032.17a.804.804 0 01-.794.679H7.72a.483.483 0 01-.477-.558L7.418 21h1.518l.95-6.02h1.385c4.678 0 7.75-2.203 8.796-6.502z"></path>
                                        <path d="M2.379 0h7.363c2.427 0 4.079.558 4.916 1.663.77.991.968 2.386.59 4.152l-.034.16c-1.009 5.087-4.293 6.807-8.546 6.807H4.513l-1.285 8.155a.69.69 0 01-.682.584H.483a.414.414 0 01-.408-.478L2.379 0z"></path>
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">PayPal</span>
                                </div>
                            </label>

                            <!-- Paiement à la livraison -->
                            <label class="flex items-center p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="cash_on_delivery"
                                       class="mr-3 text-blue-600 focus:ring-blue-500">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">Paiement à la livraison</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Notes de commande -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Notes de commande (optionnel)
                        </h3>

                        <textarea name="order_notes" 
                                  id="order_notes" 
                                  rows="4"
                                  placeholder="Instructions spéciales pour la livraison..."
                                  class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"><?php echo e(old('order_notes')); ?></textarea>
                    </div>

                </div>

                <!-- Résumé de la commande -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 sticky top-24">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Résumé de la commande
                        </h3>

                        <!-- Liste des produits -->
                        <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                            <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center gap-3 pb-3 border-b dark:border-gray-700">
                                <?php if($item->product->image): ?>
                                <img src="<?php echo e(asset('storage/' . $item->product->image)); ?>"
                                     class="w-12 h-12 rounded object-cover"
                                     alt="<?php echo e($item->product->title ?? $item->product->name); ?>">
                                <?php else: ?>
                                <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <?php endif; ?>

                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                        <?php echo e($item->product->title ?? $item->product->name); ?>

                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Qté: <?php echo e($item->quantity); ?> × $<?php echo e(number_format($item->price_at_addition, 2)); ?>

                                    </p>
                                </div>

                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    $<?php echo e(number_format($item->getSubtotal(), 2)); ?>

                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <!-- Totaux -->
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300">
                                <span>Sous-total</span>
                                <span>$<?php echo e(number_format($cart->getTotal(), 2)); ?></span>
                            </div>

                            <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300">
                                <span>Livraison</span>
                                <span class="text-green-600">Gratuite</span>
                            </div>

                            <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300">
                                <span>TVA (20%)</span>
                                <span>$<?php echo e(number_format($cart->getTotal() * 0.20, 2)); ?></span>
                            </div>
                        </div>

                        <hr class="my-4 dark:border-gray-700">

                        <div class="flex justify-between text-xl font-bold mb-6 text-gray-900 dark:text-gray-100">
                            <span>Total</span>
                            <span>$<?php echo e(number_format($cart->getTotal() * 1.20, 2)); ?></span>
                        </div>

                        <!-- Conditions générales -->
                        <div class="mb-4">
                            <label class="flex items-start">
                                <input type="checkbox" 
                                       name="terms_accepted" 
                                       required
                                       class="mt-1 mr-2 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="text-xs text-gray-600 dark:text-gray-400">
                                    J'accepte les <a href="#" class="text-blue-600 hover:underline">conditions générales de vente</a> et la <a href="#" class="text-blue-600 hover:underline">politique de confidentialité</a>
                                </span>
                            </label>
                        </div>

                        <!-- Bouton de validation -->
                        <button type="submit"
                                class="w-full px-4 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 font-semibold transition duration-200">
                            Confirmer la commande
                        </button>

                        <a href="<?php echo e(route('cart.index')); ?>"
                           class="block text-center mt-3 text-sm text-gray-600 dark:text-gray-400 hover:underline">
                            ← Retour au panier
                        </a>
                    </div>
                </div>

            </form>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\TifawinSouk-E-com\resources\views/checkout/index.blade.php ENDPATH**/ ?>