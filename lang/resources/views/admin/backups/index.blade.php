@extends('admin.layouts.app')
@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

            <form action="{{ route('backups.create') }}" method="POST">
                @csrf


                <label
                    class="mx-auto mt-8 relative bg-white flex items-center justify-center border py-2 px-2 rounded-lg gap-2 w-full"
                    for="backup">

                    <select id="backup" name="type" class="px-6 py-2 w-full rounded-md flex-1 outline-none bg-white" required>
                        <option value="">Select Backup Type</option>
                        <option value="database">Database</option>
                        <option value="codebase">Codebase</option>
                    </select>

                    <button type="submit"
                        class="px-6 py-3 bg-black border-black text-white fill-white active:scale-95 duration-100 border will-change-transform overflow-hidden relative rounded-xl transition-all">
                        <div class="flex items-center transition-all opacity-1">
                            <span class="text-sm font-semibold whitespace-nowrap truncate mx-auto">
                                <i class="fal fa-light fa-cloud-arrow-up"></i>
                                Backup
                            </span>
                        </div>
                    </button>

                </label>

            </form>


            <div>

                <div class="mt-10">
                    <h2 class="text-lg font-semibold mb-4">Database Backups</h2>
                    @include('admin.backups.partials.backup-list', [
                        'backups' => $databaseBackups,
                        'type' => 'database',
                    ])
                </div>


                <div class="mt-10">
                    <h2 class="text-lg font-semibold mb-4">Codebase Backups</h2>
                    @include('admin.backups.partials.backup-list', [
                        'backups' => $codebaseBackups,
                        'type' => 'codebase',
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
