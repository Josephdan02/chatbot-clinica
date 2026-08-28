<?php

namespace App\Services\Response;

use App\Enums\Intent;

class ResponseGenerator
{
    public function greeting(): string { return 'Hola 👋 Bienvenido/a a la Clínica Dental. ¿En qué puedo ayudarte? Puedo darte información sobre servicios, precios, horarios, ubicación, o ayudarte a agendar, consultar o cancelar una cita.'; }
    public function farewell(): string { return '¡Gracias por escribirnos! Que tengas un excelente día. 😊'; }
    public function generalInfo(): string { return 'Somos una clínica dental enfocada en brindarte la mejor atención. ¿Sobre qué te gustaría saber más: servicios, precios, horarios o ubicación?'; }
    public function askWhichService(): string { return 'Claro. ¿Sobre qué servicio deseas información? (por ejemplo: limpieza dental, ortodoncia, blanqueamiento, extracciones)'; }
    public function serviceInfo(string $service): string { return "Sobre \"{$service}\": con gusto te damos más detalles. Un miembro del equipo puede confirmarte precio exacto y disponibilidad. ¿Quieres que te ayude a agendar una cita para este servicio?"; }
    public function services(): string { return 'Nuestros servicios principales son: limpieza dental, ortodoncia, blanqueamiento, extracciones, endodoncia e implantes. ¿Sobre cuál deseas más información?'; }
    public function pricing(): string { return 'Nuestros servicios tienen diferentes precios según el tratamiento. ¿Qué tratamiento deseas consultar?'; }
    public function schedule(): string { return 'Nuestro horario de atención es de lunes a viernes de 9:00 a 18:00, y sábados de 9:00 a 13:00.'; }
    public function location(): string { return 'Estamos ubicados en Av. Principal 123. Próximamente podrás ver el mapa directamente aquí.'; }
    public function contact(): string { return 'Puedes contactarnos al +51 999 999 999 o al correo contacto@clinicadental.com.'; }
    public function askServiceForAppointment(): string { return '¡Perfecto! ¿Para qué servicio deseas agendar la cita?'; }
    public function askServiceForAvailability(): string { return 'Claro. ¿Para qué servicio deseas consultar disponibilidad?'; }
    public function askDateForAvailability(string $service): string { return "Entendido, {$service}. ¿Para qué fecha deseas consultar disponibilidad?"; }
    public function askDateForAppointment(string $service): string { return "Entendido, {$service}. ¿Qué fecha te gustaría? (ej: 2026-08-25)"; }
    public function availableSlots(string $date, array $slots): string { return 'Para el '.$date.' tenemos disponibilidad a las: '.collect($slots)->pluck('time')->join(', ').'. ¿Cuál prefieres?'; }
    public function noAvailability(string $date): string { return "Lo siento, no encontramos horarios disponibles para el {$date}. ¿Deseas probar con otra fecha?"; }
    public function invalidDate(): string { return 'La fecha no es válida. Ingresa una fecha real en formato YYYY-MM-DD, por ejemplo: 2026-08-25.'; }
    public function invalidTime(): string { return 'La hora no es válida. Ingresa una hora en formato HH:MM, por ejemplo: 10:30.'; }
    public function unavailableTime(string $time, array $slots): string { return 'El horario '.$time.' no está disponible. Puedes elegir entre: '.collect($slots)->pluck('time')->join(', ').'.'; }
    public function confirmAppointmentRequest(array $appointment): string { return "Tu solicitud de cita para \"{$appointment['service']}\" el {$appointment['date']} a las {$appointment['time']} fue registrada (estado: {$appointment['status']}). Te confirmaremos la disponibilidad final a la brevedad."; }
    public function askAppointmentConfirmation(array $appointment): string { return "Tu solicitud de cita para \"{$appointment['service']}\" el {$appointment['date']} a las {$appointment['time']} está pendiente. ¿Confirmas la cita?"; }
    public function appointmentRequestFailed(): string
{
    return 'No pudimos registrar la solicitud de cita en este momento. Por favor, intenta nuevamente.';
}

    public function appointmentConfirmed(array $appointment): string { return "Tu cita para \"{$appointment['service']}\" el {$appointment['date']} a las {$appointment['time']} fue confirmada."; }
    public function appointmentConfirmationPrompt(): string { return 'Responde sí para confirmar la cita o no para cancelarla.'; }
    public function noAppointmentFound(): string { return 'No encontramos ninguna cita registrada a tu nombre. ¿Deseas agendar una nueva?'; }
    public function noAppointmentToReschedule(): string { return 'No encontré una cita para reprogramar.'; }
    public function appointmentFound(array $appointment): string { return "Tienes una cita de \"{$appointment['service']}\" el {$appointment['date']} a las {$appointment['time']} (estado: {$appointment['status']})."; }
    public function appointmentCancelled(): string { return 'Tu cita fue cancelada correctamente. Si deseas agendar una nueva, avísame.'; }
    public function appointmentRescheduled(array $appointment): string { return "Tu cita fue reprogramada para el {$appointment['date']} a las {$appointment['time']} (estado: {$appointment['status']})."; }
    public function humanHandoff(): string { return 'Entendido, en un momento un miembro de nuestro equipo continuará la conversación contigo. Por favor espera un momento. 🙏'; }
    public function conversationClosed(): string { return 'Esta conversación fue cerrada. Escríbenos de nuevo cuando quieras. 👋'; }
    public function unknown(): string { return 'Disculpa, no logré entender tu mensaje. ¿Podrías reformularlo? También puedo ponerte en contacto con una persona si lo prefieres.'; }

    public function forIntent(Intent $intent): string
    {
        return match ($intent) {
            Intent::GREETING => $this->greeting(), Intent::FAREWELL => $this->farewell(),
            Intent::APPOINTMENT_REQUEST_FAILED => $this->appointmentRequestFailed(),
            Intent::GENERAL_INFO => $this->generalInfo(), Intent::SERVICES => $this->services(),
            Intent::PRICING => $this->pricing(), Intent::SCHEDULE => $this->schedule(),
            Intent::LOCATION => $this->location(), Intent::CONTACT => $this->contact(),
            Intent::HUMAN_HANDOFF => $this->humanHandoff(), default => $this->unknown(),
        };
    }
}
