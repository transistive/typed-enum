pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                sh 'docker build -t php-typed-enum:latest .'
            }
        }
        stage('Static Analysis') {
            steps {
                sh 'docker run -it php-typed-enum:latest vendor/bin/php-cs-fixer fix --dry-run'
                sh 'docker run -it php-typed-enum:latest vendor/bin/psalm --show-info=true'
            }
        }
        stage('Test') {
            steps {
                sh 'docker run -it php-typed-enum:latest vendor/bin/phpunit'
            }
        }
    }
}
