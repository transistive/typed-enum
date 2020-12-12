pipeline {
    agent any

    environment {
        BRANCH_NAME = "${GIT_BRANCH.split("/").size() > 1 ? GIT_BRANCH.split("/")[1] : GIT_BRANCH}"
    }

    stages {
        stage('Pull') {
            steps {
                sh 'docker-compose -p typed-enum-$BRANCH_NAME -f docker/docker-compose.yml pull'
            }
        }
        stage('Build') {
            steps {
                sh 'docker build -t php-typed-enum:static-analysis-$BRANCH_NAME .'
                sh 'docker-compose -p typed-enum-$BRANCH_NAME -f docker/docker-compose.yml build --parallel'
            }
        }
        stage('Static Analysis') {
            steps {
                sh 'docker run php-typed-enum:static-analysis-$BRANCH_NAME tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --dry-run'
                sh 'docker run php-typed-enum:static-analysis-$BRANCH_NAME tools/psalm/vendor/bin/psalm --show-info=true'
            }
        }
        stage('Test') {
            steps {
                sh 'docker-compose -f docker/docker-compose.yml -p typed-enum-$BRANCH_NAME run client-80 php vendor/bin/phpunit'
                sh 'docker-compose -f docker/docker-compose.yml -p typed-enum-$BRANCH_NAME run client-74 php vendor/bin/phpunit'
            }
        }
        stage ('Coverage') {
            steps {
                sh 'docker-compose -f docker/docker-compose.yml -p typed-enum-$BRANCH_NAME run client sh -c "\
                    git checkout -B $BRANCH_NAME && \
                    cc-test-reporter before-build && \
                    vendor/bin/phpunit --config phpunit.coverage.xml.dist -d memory_limit=1024M && \
                    cp out/phpunit/clover.xml clover.xml && \
                    cc-test-reporter after-build --id 81fb333da6e4359d50bde9e707693157a016508877cc12f6737e6046938c89eb --exit-code 0"'
            }
        }
    }

     post {
        always {
            sh 'docker-compose -f docker/docker-compose.yml -p typed-enum-$BRANCH_NAME down --volumes'
        }
    }
}
