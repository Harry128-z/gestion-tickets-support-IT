pipeline {
    agent any

    stages {
        stage('Fetch Code') {
            steps {
                // Récupérer le code depuis le dépôt Git
                git branch: 'main', url: 'https://github.com/Harry128-z/gestion-tickets-support-IT.git'
            }
        }

        stage('Build Application') {
            steps {
                // Construire le projet, par exemple avec npm ou une autre commande
                bat 'npm install' // Commande Windows
                bat 'npm run build' // Exemple pour Node.js
            }
        }

       stage('Test Application') {
    steps {
        echo 'Pas de tests pour le moment. Étape ignorée.'
    }
           
        }

        stage('Build Docker Image') {
            steps {
                // Construire l'image Docker
                bat 'docker build -t votre-utilisateur/app:latest .'
            }
        }

        stage('Push Docker Image') {
            steps {
                withDockerRegistry([ credentialsId: 'dockerhub-creds', url: '' ]) {
                    // Pousser l'image dans Docker Hub
                    bat 'docker push votre-utilisateur/app:latest'
                }
            }
        }

        stage('Deploy with Docker Compose') {
            steps {
                // Déployer l'application
                bat 'docker-compose down' // Arrêter les conteneurs existants
                bat 'docker-compose up -d' // Redémarrer avec la nouvelle image
            }
        }
    }

    post {
        success {
            echo 'Pipeline exécuté avec succès.'
        }
        failure {
            echo 'Pipeline échoué. Vérifiez les logs.'
        }
    }
}
