<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un fournisseur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-black">

    <div class="w-full flex flex-col items-center p-8">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold">
                Ajouter un fournisseur
            </h1>
        </div>

        <div class="max-w-xl border border-gray-200 rounded-lg p-6 ">
            <form action="<?php echo e(route('admin.fournisseurs.store')); ?>" method="POST" class="space-y-5">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm mb-1">Nom</label>
                    <input type="text" name="name"
                           class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-1 focus:ring-black">
                </div>

                
                <div>
                    <label class="block text-sm mb-1">Email</label>
                    <input type="email" name="email"
                           class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-1 focus:ring-black">
                </div>

                <div>
                    <label class="block text-sm mb-1">Téléphone</label>
                    <input type="text" name="phone"
                           class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-1 focus:ring-black">
                </div>

                <div class="flex items-center gap-3 pt-4">
                    
                    <a href="/admin/fournisseurs"
                    class="px-4 py-2 border border-black rounded hover:bg-black hover:text-white transition">
                    Annuler
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-black text-white rounded hover:bg-gray-900 transition">
                    Enregistrer
                </button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
<?php /**PATH C:\laragon\www\TifawinSoukV2\resources\views/admin/fournisseurs/create.blade.php ENDPATH**/ ?>