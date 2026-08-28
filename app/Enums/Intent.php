<?php

namespace App\Enums;

enum Intent: string
{
    case GREETING = 'greeting';
    case FAREWELL = 'farewell';
    case GENERAL_INFO = 'general_info';
    case SERVICES = 'services';
    case PRICING = 'pricing';
    case SCHEDULE = 'schedule';
    case LOCATION = 'location';
    case CONTACT = 'contact';
    case CHECK_APPOINTMENT = 'check_appointment';
    case REQUEST_APPOINTMENT = 'request_appointment';
    case AVAILABILITY = 'availability';
    case CANCEL_APPOINTMENT = 'cancel_appointment';
    case RESCHEDULE_APPOINTMENT = 'reschedule_appointment';
    case HUMAN_HANDOFF = 'human_handoff';
    case UNKNOWN = 'unknown';
}
