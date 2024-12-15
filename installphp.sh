#!/bin/bash

# Installer PHP si ce n'est pas déjà installé
if ! command -v php &> /dev/null
then
    echo "PHP non trouvé, installation..."
    sudo apt-get update
    sudo apt-get install -y php
    echo "PHP installé avec succès."
else
    echo "PHP est déjà installé."
fi
