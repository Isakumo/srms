<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login | SRMS</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-slate-100">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-slate-800">Login</h2>

                @if ($errors->any())
                    <div class="mt-4 rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="/login" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700" for="username">Username</label>
                        <input id="username" name="username" type="text" value="{{ old('username') }}" class="mt-1 w-full rounded border-slate-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700" for="password">Password</label>
                        <input id="password" name="password" type="password" class="mt-1 w-full rounded border-slate-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="remember" value="1">
                            Remember me
                        </label>
                        <a href="#" class="text-sm text-indigo-600">Forgot password?</a>
                    </div>

                    <button type="submit" class="w-full rounded bg-indigo-600 px-4 py-2 font-semibold text-white">Sign in</button>
                </form>
            </div>
        </div>
    </body>
</html>
