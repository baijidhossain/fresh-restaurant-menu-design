@extends('admin.layouts.app')
@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
                @lang('crud.codes.index_title')
            </h2>
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text name="search" value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }}" autocomplete="off"></x-inputs.text>

                                    <div class="ml-1">
                                        <button type="submit"
                                            class="rounded bg-primary px-6 py-3 font-medium hover:bg-opacity-90 text-white">
                                            <i class="fa-duotone fa-magnifying-glass"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">

                            <a href="{{ route('codes.export') }}"
                                class="rounded bg-success px-6 py-3 font-medium hover:bg-opacity-90 text-white mr-2">
                                <i class="mr-1 fa-duotone fa-download"></i>
                                Export
                            </a>

                            @can('create', App\Models\Code::class)
                                <a href="{{ route('codes.create') }}"
                                    class="rounded bg-primary px-6 py-3 font-medium hover:bg-opacity-90 text-white">
                                    <i class="mr-1 fa-duotone fa-circle-plus"></i>
                                    Generate
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:text-gray-400">
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.codes.inputs.code')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.codes.inputs.has_card')
                                </th>
                                <th class="px-4 py-3 text-left text-gray-500">
                                    Used By
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($codes as $code)
                                <tr
                                    class="hover:bg-gray-50 {{ $loop->index % 2 == 0 ? '' : 'bg-gray-50' }} {{ $loop->last ? '' : 'border-b border-stroke' }}">
                                    <td class="px-4 py-3 text-left">
                                        {{ $code->code ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">

                                        <i
                                            class="{{ $code->has_card ? 'fa-duotone fa-check-circle text-green-500' : 'fa-duotone fa-question-circle text-red-500' }}"></i>
                                    </td>

                                    <td class="px-4 py-3 text-left">
                                        @if ($code->contact)
                                            <a href="{{ route('restaurant_user.show', $code->contact) }}" target="_blank"
                                                rel="noopener noreferrer"
                                                class="hover:underline">{{ $code->contact->name }}</a>
                                        @else
                                            Not Used
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions"
                                            class="
                                            relative
                                            inline-flex
                                            align-middle
                                        ">

                                            <a href="javascript:void(0)" class="mr-1">
                                                <button type="button"
                                                    onclick="copyLink('{{ request()->getSchemeAndHttpHost() . '/scan/' . $code->code }}')"
                                                    class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-orange-600 border border-transparent rounded-md hover:bg-orange-700 focus:outline-none focus:border-orange-700 focus:shadow-outline-blue active:bg-orange-700"><i
                                                        class="fa-duotone fa-copy"></i></button>
                                            </a>

                                            @can('update', $code)
                                                <a href="{{ route('codes.edit', $code) }}" class="mr-1">
                                                    <button type="button"
                                                        class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">
                                                        <i class="fa-duotone fa-pencil"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('view', $code)
                                                <a href="{{ route('codes.show', $code) }}" class="mr-1">
                                                    <button type="button"
                                                        class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green active:bg-green-700">
                                                        <i class="fa-duotone fa-eye"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('delete', $code)
                                                <form action="{{ route('codes.destroy', $code) }}" method="POST"
                                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700">
                                                        <i class="fa-duotone fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    <div class="mt-10 px-4">
                                        {!! $codes->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
@endsection


<script>
    function copyLink(url) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            // Modern browsers
            navigator.clipboard.writeText(url)
                .then(() => notifySuccess())
                .catch((error) => notifyError(error));
        } else {
            // Fallback for older browsers
            fallbackCopyTextToClipboard(url);
        }
    }

    function fallbackCopyTextToClipboard(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;

        // Avoid scrolling to bottom
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            var successful = document.execCommand('copy');
            if (successful) {
                notifySuccess();
            } else {
                notifyError('Unable to copy');
            }
        } catch (err) {
            notifyError(err);
        }

        document.body.removeChild(textArea);
    }

    function notifySuccess() {
        var notyf = new Notyf({
            dismissible: true,
            duration: 2000
        });
        notyf.success('Copied to clipboard!');
    }

    function notifyError(error) {
        var notyf = new Notyf({
            dismissible: true,
            duration: 2000
        });
        notyf.error('Failed to copy: ' + error);
    }
</script>
