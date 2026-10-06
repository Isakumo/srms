<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard | SRMS</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-slate-100 text-slate-800">
        <div class="min-h-screen">
            <nav class="bg-slate-900 text-white px-6 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold">SRMS</h1>
                </div>
                <div class="flex items-center gap-4">
                    <span>{{ $user->username }}</span>
                    <form method="POST" action="/logout">
                        @csrf
                        <button class="rounded bg-white px-3 py-2 text-sm font-medium text-slate-900">Logout</button>
                    </form>
                </div>
            </nav>

            <main class="mx-auto max-w-6xl p-6">
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="rounded-xl bg-white p-5 shadow">
                        <p class="text-sm text-slate-500">Account status</p>
                        <p class="mt-2 text-2xl font-bold">{{ $user->status }}</p>
                    </div>
                    <div class="rounded-xl bg-white p-5 shadow">
                        <p class="text-sm text-slate-500">Roles</p>
                        <p class="mt-2 text-2xl font-bold">{{ $roles->count() }}</p>
                    </div>
                    <div class="rounded-xl bg-white p-5 shadow">
                        <p class="text-sm text-slate-500">School</p>
                        <p class="mt-2 text-2xl font-bold">{{ optional($user->school)->name ?? 'System account' }}</p>
                    </div>
                </div>

                <div class="mt-8 rounded-xl bg-white p-6 shadow">
                    <h2 class="text-lg font-semibold">Role permissions</h2>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach ($roles as $role)
                            @foreach ($role->permissions as $permission)
                                <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-700">{{ $permission->code }}</span>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
