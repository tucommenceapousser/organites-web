import os
import subprocess

# Définir le port
PORT = 8080

# Définir le chemin du projet
PROJECT_DIR = os.getcwd()

# Commande pour démarrer le serveur PHP intégré
cmd = ["php", "-S", f"0.0.0.0:{PORT}", "-t", PROJECT_DIR]

print(f"Starting PHP server at http://localhost:{PORT}...")
try:
    subprocess.run(cmd)
except KeyboardInterrupt:
    print("\nServer stopped.")
