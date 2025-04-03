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
                sh 'docker-compose build'
            }
        }

        stage('Run Tests') {
            steps {
                sh 'docker-compose run app php artisan test'
            }
        }

        stage('Deploy') {
            steps {
                sh 'docker-compose down'
                sh 'docker-compose up -d'
            }
        }
    }

    post {
        always {
            sh 'docker system prune -f'
        }
    }
}