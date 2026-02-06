// Jenkinsfile
pipeline {
    agent any
    
    environment {
        APP_NAME = 'ScrappingOffresEmploi'
        VERSION = "${env.BUILD_NUMBER}"
    }
    
    stages {
        stage('Checkout') {
            steps {
                echo 'Cloning repository...'
                git branch: 'main',
                    url: 'https://github.com/prada23158/ScrapinAPP'
            }
        }
        
        stage('Build') {
            steps {
                echo "Building ${APP_NAME} version ${VERSION}"
                sh '''
                    echo "Simulating build..."
                    mkdir -p dist
                    echo "Build ${VERSION}" > dist/app.txt
                '''
            }
        }
        
        stage('Test') {
            steps {
                echo 'Running tests...'
                sh '''
                    echo "Running unit tests..."
                    # Simulez des tests
                    if [ -f dist/app.txt ]; then
                        echo "Tests passed!"
                    else
                        exit 1
                    fi
                '''
            }
        }
        
        stage('Archive') {
            steps {
                archiveArtifacts artifacts: 'dist/**', fingerprint: true
            }
        }
    }
    
    post {
        success {
            echo 'Pipeline succeeded!'
        }
        failure {
            echo 'Pipeline failed!'
        }
        always {
            cleanWs()  // nettoie le workspace
        }
    }
}
