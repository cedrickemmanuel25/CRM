<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8fafc; padding: 20px; text-align: center; border-bottom: 2px solid #6366f1; }
        .content { padding: 30px 20px; background-color: #ffffff; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
        .button { display: inline-block; background-color: #6366f1; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Bienvenue, {{ $contact->prenom }} !</h2>
        </div>
        <div class="content">
            <p>Bonjour {{ $contact->nom_complet }},</p>
            
            <p>Nous sommes ravis de vous compter parmi nos nouveaux contacts.</p>
            
            <p>Votre dossier a été créé avec succès par <strong>{{ $contact->owner->name ?? 'notre équipe' }}</strong>.</p>
            
            <p>N'hésitez pas à nous contacter si vous avez des questions ou si vous souhaitez discuter de vos projets.</p>
            
            <p>Cordialement,<br>
            L'équipe {{ config('app.name') }}</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
