<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fournisseurs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-black">

    <div class="min-h-screen p-8">
        <div class="w-full flex justify-between mb-2">
            <h1 class="text-2xl font-semibold mb-6">
                Liste des fournisseurs
            </h1>

            <a href="fournisseurs/create" class="rounded-2xl p-2 bg-black text-white flex items-center justify-center">Ajoute un fournisseurs</a>
        </div>

        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="w-full text-sm">
                <thead class="bg-black text-white">
                    <tr>
                        <th class="px-6 py-3 text-left">Nom</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Téléphone</th>
                        <th class="px-6 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $fournisseurs_archives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fournisseur_archive): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-6 py-4"><?php echo e($fournisseur_archive->name); ?></td>
                        <td class="px-6 py-4"><?php echo e($fournisseur_archive->email); ?></td>
                        <td class="px-6 py-4"><?php echo e($fournisseur_archive->phone); ?></td>
                        <td class="px-6 py-4 flex flex-wrap gap-5">
                            <a href="<?php echo e(route('admin.fournisseurs.archive')); ?>" class="text-yellow-500">rej3o</a>
                            <a href="<?php echo e(route('admin.fournisseurs.edit')); ?>" class="text-red-800">Supprime</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>
<?php /**PATH C:\laragon\www\TifawinSoukV2\resources\views/admin/fournisseurs/archive.blade.php ENDPATH**/ ?>