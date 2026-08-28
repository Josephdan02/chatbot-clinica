<?php

namespace App\Enums;

enum ConversationState: string
{
    case IDLE = 'idle';
    case IN_PROGRESS = 'in_progress';
    case HANDOFF_TO_HUMAN = 'handoff_to_human';
    case CLOSED = 'closed';
}
