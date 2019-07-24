@can ('disableVote', $model)
    <a title="Must another user to vote" class="vote-up off" style="cursor:default">
        <i class="fas fa-caret-up fa-3x"></i>
    </a>
    <span class="vote-count">{{ $model->votes_count }}</span>
    <a title="This answer is not usefull" class="vote-down off" style="cursor:default">
        <i class="fas fa-caret-down fa-3x"></i>
    </a>
@elseif (Auth::check())
    <a title="This answer is usefull" class="vote-up {{ Auth::guest() ? 'off' : '' }}" onclick="event.preventDefault(); document.getElementById('up-vote-answer-{{ $model->id }}').submit();">
        <i class="fas fa-caret-up fa-3x"></i>
    </a>
    <form id="up-vote-answer-{{ $model->id }}" action="/answers/{{ $model->id }}/vote" method="post" style="display:none;">
        @csrf
        <input type="hidden" name="vote" value="1">
    </form>
    <span class="vote-count">{{ $model->votes_count }}</span>
    <a title="This answer is not usefull" class="vote-down {{ Auth::guest() ? 'off' : '' }}" onclick="event.preventDefault(); document.getElementById('down-vote-answer-{{ $model->id }}').submit();">
        <i class="fas fa-caret-down fa-3x"></i>
    </a>
    <form id="down-vote-answer-{{ $model->id }}" action="/answers/{{ $model->id }}/vote" method="post" style="display:none;">
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>
@else
    <a title="You cannot vote this answer except logged in" class="vote-up off" style="cursor:default">
        <i class="fas fa-caret-up fa-3x"></i>
    </a>
    <span class="vote-count">{{ $model->votes_count }}</span>
    <a title="You cannot vote this answer except logged in" class="vote-down off" style="cursor:default">
        <i class="fas fa-caret-down fa-3x"></i>
    </a>
@endcan