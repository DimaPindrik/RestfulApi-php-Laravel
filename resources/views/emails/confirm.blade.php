Hello {{$user->name}} !
You changed your email, so we need to verify this new address. Please verify your email using this link:
{{route('verify', $user->verification_token)}}