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

            <div class="flex gap-3">
                <a href="{{ route('admin.fournisseurs.create') }}"
                    class="px-5 py-2 rounded-2xl bg-black text-white flex items-center justify-center hover:bg-gray-800 transition">
                    Ajouter un fournisseur
                </a>

                <a href="{{ route('admin.fournisseurs.archive') }}"
                    class="px-5 py-2 rounded-2xl bg-black text-white flex items-center justify-center hover:bg-gray-800 transition">
                    Archive
                </a>
            </div>
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
                    @foreach ($fournisseurs as $fournisseur)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-6 py-4">{{ $fournisseur->name }}</td>
                            <td class="px-6 py-4">{{ $fournisseur->email }}</td>
                            <td class="px-6 py-4">{{ $fournisseur->phone }}</td>
                            <td class="px-6 py-4 flex flex-wrap gap-5">
                                <form action="{{ route('admin.fournisseurs.trash', $fournisseur->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">archive</button>
                                </form>
                                <a href="{{ route('admin.fournisseurs.edit', $fournisseur->id) }}"
                                    class="text-yellow-400">edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>