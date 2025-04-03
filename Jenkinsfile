pipeline {
    agent any

    environment {
        DOCKER_IMAGE = "gestion-tickets-app:latest"
    }

    stages {
        stage('Checkout') {
            steps {
                // Utiliser les identifiants pour cloner le dépôt
                git branch: 'main', url: 'https://github.com/Harry128-z/gestion-tickets-support-IT.git', credentialsId: 'Github-credentials237'
            }
        }

        stage('Build Docker Image') {
            steps {
                bat 'docker-compose build'
            }
        }

        stage('Run Tests') {
            steps {
                bat 'docker-compose run app php artisan test'
            }
        }

        stage('Deploy') {
            steps {
                bat 'docker-compose down'
                bat 'docker-compose up -d'
            }
        }
    }

    post {
        always {
            bat 'docker system prune -f'
        }
    }
}