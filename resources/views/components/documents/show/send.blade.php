<x-show.accordion type="send" :open="($accordionActive == 'send')">
    <x-slot name="head">
        <x-show.accordion.head
            title="{{ trans('general.send') }}"
            description="{!! trans($description, [
                'user' => $user_name,
                'type' => $type_lowercase,
                'date' => $last_sent_date,
            ]) !!}"
        />
    </x-slot>

    <x-slot name="body">
        @stack('timeline_send_body_start')

        <div class="flex flex-wrap space-x-3 rtl:space-x-reverse">
            @stack('timeline_send_body_button_email_start')

            @if (! $hideEmail)
                @if ($document->contact->has_email)
                    @if ($document->status != 'cancelled')
                        <x-button id="show-slider-actions-send-email-{{ $document->type }}" kind="secondary" @click="onSendEmail('{{ route($emailRoute, $document->id) }}')">
                            {{ trans($textEmail) }}
                        </x-button>
                    @else
                        <x-button kind="disabled" disabled="disabled">
                            {{ trans($textEmail) }}
                        </x-button>
                    @endif
                @else
                    <x-tooltip message="{{ trans('invoices.messages.email_required') }}" placement="top">
                        <x-dropdown.button disabled="disabled">
                            {{ trans($textEmail) }}
                        </x-dropdown.button>
                    </x-tooltip>
                @endif
            @endif

            @stack('timeline_send_body_button_mark_sent_start')

            @if (! $hideMarkSent)
                @can($permissionUpdate)
                    @if ($document->status == 'draft')
                        <x-link id="show-slider-actions-mark-sent-{{ $document->type }}" href="{{ route($markSentRoute, $document->id) }}" @click="e => e.target.classList.add('disabled')">
                            <x-link.loading>
                                {{ trans($textMarkSent) }}
                            </x-link.loading>
                        </x-link>
                    @else
                        <x-button kind="disabled" disabled="disabled">
                            {{ trans($textMarkSent) }}
                        </x-button>
                    @endif
                @endcan
            @endif

            @stack('timeline_send_body_button_cancelled_start')

            @if (! $hideShare)
                @if ($document->status != 'cancelled')
                    <x-button id="show-slider-actions-share-link-{{ $document->type }}" @click="onShareLink('{{ route($shareRoute, $document->id) }}')">
                        {{ trans('general.share_link') }}
                    </x-button>
                @endif
            @endif

            @stack('timeline_send_body_button_cancelled_end')

            @stack('timeline_send_body_history_start')

            @if ($histories->count())
                <div class="text-xs mt-6" style="margin-left: 0 !important;">
                    <span class="font-medium">
                        {{ trans_choice('general.histories', 1) }}:
                    </span>

                    @foreach ($histories as $history)
                        <div class="my-4">
                            <span>
                                {{ trans('documents.slider.send', [
                                    'user' => $history->owner->name,
                                    'type' => $type_lowercase,
                                    'date' => company_date($history->created_at),
                                ]) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif

            @stack('timeline_send_body_history_end')
        </div>

        @stack('timeline_get_paid_body_end')
    </x-slot>
</x-show.accordion>
