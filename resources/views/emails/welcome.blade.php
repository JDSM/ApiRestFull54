Hola {{$user->name}}
Gracias por crear una cuenta. Por favor verificala en el siguiente link:
{{route('verify', $user->verification_token)}}