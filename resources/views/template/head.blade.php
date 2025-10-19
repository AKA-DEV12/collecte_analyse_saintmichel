<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Donnee St Michel d‘adjame</title>
  <link rel="shortcut icon" type="image/png" href="{{asset('/assets/images/logos/favicon.png')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/styles.min.css')}}" />

  <style>
     .btn-remove-field {
  background: rgba(220, 53, 69, 0.9);
  border: none;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.btn-remove-field:hover {
  background: var(--danger-color);
  transform: scale(1.05);
}
/* Animation de scroll horizontal */
@keyframes scrollText {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}

.animate-scroll {
    white-space: nowrap;
    display: inline-block;
    animation: scrollText 20s linear infinite;
}
  </style>
  @stack('css')
</head>

