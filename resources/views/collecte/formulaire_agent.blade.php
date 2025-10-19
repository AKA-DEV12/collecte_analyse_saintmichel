<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recensement des Paroissiens</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)),
                        url('/placeholder.svg?height=1080&width=1920') center/cover no-repeat fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 2rem 0;
        }

        .glass-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            padding: 0;
            overflow: hidden;
            max-width: 900px;
            margin: 0 auto;
        }

        .header-section {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.9), rgba(59, 130, 246, 0.9));
            padding: 3rem 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-section h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .header-section p {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.1rem;
            margin: 0;
        }

        .info-badge {
            background: rgba(16, 185, 129, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(16, 185, 129, 0.4);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin: 2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .info-badge svg {
            width: 24px;
            height: 24px;
            fill: #10b981;
        }

        .form-section {
            padding: 2.5rem;
        }

        .form-label {
            color: white;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            color: white;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(59, 130, 246, 0.6);
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
            color: white;
            outline: none;
        }

        .form-select {
            color: white;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='white' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        }

        .form-select option {
            background: rgba(30, 58, 138, 0.95);
            color: white;
        }

        .btn-submit {
            background: linear-gradient(135deg, #3b82f6, #1e3a8a);
            border: none;
            border-radius: 12px;
            color: white;
            padding: 1rem 3rem;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            margin-top: 1.5rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.6);
            background: linear-gradient(135deg, #2563eb, #1e40af);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Custom date input styling */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .header-section h1 {
                font-size: 1.8rem;
            }

            .form-section {
                padding: 1.5rem;
            }

            .glass-container {
                margin: 0 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="glass-container">
            <div class="header-section">
                <h1>Recensement des Paroissiens</h1>
                <p>Remplissez ce formulaire pour le recensement des paroissiens de la Paroisse Saint Michel d'Adjamé</p>
            </div>

            <div class="text-center">
                <div class="info-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                        <path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/>
                    </svg>
                    <span>Nous avons <strong>17 Paroissiens enregistrés</strong></span>
                </div>
            </div>

            <div class="form-section">
                <form id="parishForm">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom *</label>
                            <input type="text" class="form-control" id="nom" placeholder="Votre nom" required>
                        </div>
                        <div class="col-md-6">
                            <label for="prenoms" class="form-label">Prénoms *</label>
                            <input type="text" class="form-control" id="prenoms" placeholder="Vos prénoms" required>
                        </div>

                        <div class="col-md-6">
                            <label for="dateNaissance" class="form-label">Date de naissance *</label>
                            <input type="date" class="form-control" id="dateNaissance" required>
                        </div>
                        <div class="col-md-6">
                            <label for="quartier" class="form-label">Quartier *</label>
                            <input type="text" class="form-control" id="quartier" placeholder="Votre quartier" required>
                        </div>

                        <div class="col-md-6">
                            <label for="baptise" class="form-label">Baptisé *</label>
                            <select class="form-select" id="baptise" required>
                                <option value="" selected>Sélectionnez une option</option>
                                <option value="oui">Oui</option>
                                <option value="non">Non</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="confirme" class="form-label">Confirmé *</label>
                            <select class="form-select" id="confirme" required>
                                <option value="" selected>Sélectionnez une option</option>
                                <option value="oui">Oui</option>
                                <option value="non">Non</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="professionFoi" class="form-label">Profession de foi *</label>
                            <select class="form-select" id="professionFoi" required>
                                <option value="" selected>Sélectionnez une option</option>
                                <option value="oui">Oui</option>
                                <option value="non">Non</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="marie" class="form-label">Marié *</label>
                            <select class="form-select" id="marie" required>
                                <option value="" selected>Sélectionnez une option</option>
                                <option value="oui">Oui</option>
                                <option value="non">Non</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="telephone" class="form-label">Téléphone *</label>
                            <input type="tel" class="form-control" id="telephone" placeholder="+225 XX XX XX XX XX" required>
                        </div>
                        <div class="col-md-6">
                            <label for="whatsapp" class="form-label">Numéro whatsapp</label>
                            <input type="tel" class="form-control" id="whatsapp" placeholder="+225 XX XX XX XX XX">
                        </div>

                        <div class="col-md-6">
                            <label for="situationPro" class="form-label">Situation Professionnelle *</label>
                            <select class="form-select" id="situationPro" required>
                                <option value="" selected>Sélectionnez une option</option>
                                <option value="employe">Employé</option>
                                <option value="independant">Indépendant</option>
                                <option value="etudiant">Étudiant</option>
                                <option value="chomage">Sans emploi</option>
                                <option value="retraite">Retraité</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="nomCEB" class="form-label">Nom de la CEB</label>
                            <input type="text" class="form-control" id="nomCEB" placeholder="Nom de votre CEB">
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-submit">Soumettre le formulaire</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation and submission
        document.getElementById('parishForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = {
                nom: document.getElementById('nom').value,
                prenoms: document.getElementById('prenoms').value,
                dateNaissance: document.getElementById('dateNaissance').value,
                quartier: document.getElementById('quartier').value,
                baptise: document.getElementById('baptise').value,
                confirme: document.getElementById('confirme').value,
                professionFoi: document.getElementById('professionFoi').value,
                marie: document.getElementById('marie').value,
                telephone: document.getElementById('telephone').value,
                whatsapp: document.getElementById('whatsapp').value,
                situationPro: document.getElementById('situationPro').value,
                nomCEB: document.getElementById('nomCEB').value
            };

            // Validate form
            if (this.checkValidity()) {
                console.log('Form data:', formData);
                alert('Formulaire soumis avec succès! Les données ont été enregistrées.');
                this.reset();
            } else {
                this.classList.add('was-validated');
            }
        });

        // Add smooth focus effects
        const inputs = document.querySelectorAll('.form-control, .form-select');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.parentElement.style.transition = 'transform 0.2s ease';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>