<table class="match-table" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <?php /** @var \App\User $match */ ?>
                @foreach($matches as $match)
                <tr>
                    <td class="match-table__item match-table__item--small">
                        <a href="{{ route('pub.user.show', $match->username) }}" target="_blank">
                            <img src="{{ $match->avatarUrl(\App\Enums\AvatarSizeEnum::MEDIUM) }}" class="match-table__img">
                        </a>
                    </td>
                    <td class="match-table__item">
                        {{ $match->first_name }}<br />
                        @if ($match->user_type === 'broker')
                            <span class="match-table__text--small">Lender</span><br />
                        @else
                            <span class="match-table__text--small">{{ title_case($match->user_type) }}</span><br />
                        @endif
                        <span class="match-table__text--small">{{ $match->city }}, {{ $match->state }}</span>
                    </td>
                    <td class="match-info__item">
                        <a href="{{ route('pub.user.show', $match->username) }}" class="button button-blue" target="_blank">View Profile</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>