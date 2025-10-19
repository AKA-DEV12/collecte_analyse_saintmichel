<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Export Recensements</title>
  <style>
    table { width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px; }
    th, td { border: 1px solid #ddd; padding: 6px 8px; }
    th { background: #f3f4f6; text-align: left; }
  </style>
</head>
<body>
  <table>
    <thead>
      <tr>
        <th>Nom</th>
        <th>Quartier</th>
        <th>CEB</th>
        <th>Baptisé</th>
        <th>Confirmé</th>
        <th>Profession de foi</th>
        <th>Situation Matrimoniale</th>
        <th>Situation Professionnel</th>
        <th>Téléphone</th>
        <th>Whatsapp</th>
        <th>Date de naissance</th>
        <th>Enregistré par</th>
      </tr>
    </thead>
    <tbody>
    @foreach($items as $recensement)
      <tr>
        <td>{{ $recensement->nom }}</td>
        <td>{{ $recensement->quartier }}</td>
        <td>{{ $recensement->ceb }}</td>
        <td>{{ $recensement->baptise ? 'Oui' : 'Non' }}</td>
        <td>{{ $recensement->confirme ? 'Oui' : 'Non' }}</td>
        <td>{{ $recensement->profession_de_foi ? 'Oui' : 'Non' }}</td>
        <td>
          @switch($recensement->situation_matrimoniale)
            @case(0) Célibataire @break
            @case(1) Marié(e) @break
            @case(2) Divorcé(e) @break
            @case(3) Veuf/veuve @break
            @case(4) Mariage Traditionnel @break
            @case(5) Autre @break
            @default
          @endswitch
        </td>
        <td>{{ $recensement->situation_professionnelle }}</td>
        <td>{{ $recensement->telephone }}</td>
        <td>{{ $recensement->numero_whatsapp }}</td>
        <td>{{ $recensement->date_naissance }}</td>
        <td>{{ optional($recensement->createur)->name }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
</body>
</html>
