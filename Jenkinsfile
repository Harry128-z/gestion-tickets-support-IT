pipeline {
    agent any

    environment {
        DOCKER_IMAGE = "gestion-tickets-app:latest"
    }

    stages {
        stage('Checkout') {
            steps {
                // Cloner le dépôt Git
                git branch: 'main', url: 'https://github.com/username/gestion-tickets-support-IT.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                // Construire l'image Docker
                sh 'docker-compose build'
            }
        }

        stage('Run Tests') {
            steps {
                // Exécuter les tests Laravel
                sh 'docker-compose run app php artisan test'
            }
        }

        stage('Deploy') {
            steps {
                // Déployer avec Docker Compose
                sh 'docker-compose down'
                sh 'docker-compose up -d'
            }
        }
    }

    post {
        always {
            // Nettoyer les conteneurs inutilisés
            sh 'docker system prune -f'
        }
    }
}