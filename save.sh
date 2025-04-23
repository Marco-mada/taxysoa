#!/bin/bash

# Récupérer le message de commit
echo "💡 Décrivez brièvement votre modification :"
read message

# Créer une nouvelle branche si on n'est pas sur une branche feature/
current_branch=$(git branch --show-current)
if [[ $current_branch == "main" || $current_branch == "develop" ]]; then
    echo "🔄 Création d'une nouvelle branche..."
    # Utiliser la date pour un nom unique
    branch_name="feature/modif-$(date +%Y%m%d-%H%M%S)"
    git checkout -b $branch_name
fi

# Sauvegarder les modifications
echo "💾 Sauvegarde des modifications..."
git add .
git commit -m "feat: $message"

# Pousser vers GitHub
echo "⬆️ Envoi vers GitHub..."
git push origin $(git branch --show-current)

echo "✅ Terminé ! Allez sur GitHub pour créer la Pull Request."
echo "🌐 URL: https://github.com/Marco-mada/taxysoa/pulls" 