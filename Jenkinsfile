pipeline {
  agent any
  stages {

    stage('Build') {
      steps {
        sh 'mkdir silverstripe-cache'
        sh 'composer require --prefer-dist --no-update silverstripe-themes/simple:~3.2'
        sh 'composer update --no-suggest --prefer-dist'
      }
    }

    stage('PHPUnit') {
      steps {
        sh 'vendor/bin/phpunit --log-junit=build/logs/junit.xml --coverage-xml=build/logs/coverage'
      }
    }

	stage('Checkstyle Report') {
      steps {
        sh 'vendor/bin/phpcs --report=checkstyle --report-file=build/logs/checkstyle.xml --standard=phpcs.xml.dist --extensions=php,inc --ignore=autoload.php --ignore=vendor/ src/ tests/ || exit 0'
	  }
    }

    stage('Mess Detection Report') {
	  steps {
	    sh 'vendor/bin/phpmd src xml codesize,unusedcode,naming --reportfile build/logs/pmd.xml --exclude vendor/ --exclude autoload.php || exit 0'
  	  }
    }

    stage('CPD Report') {
	  steps {
	    sh 'vendor/bin/phpcpd --log-pmd build/logs/pmd-cpd.xml --exclude vendor src/ tests/ || exit 0'
	  }
    }

    stage('Lines of Code') {
	  steps {
	    sh 'vendor/bin/phploc --count-tests --exclude vendor/ --log-csv build/logs/phploc.csv --log-xml build/logs/phploc.xml src/ tests/'
	  }
    }

    stage('Software metrics') {
	  steps {
	    sh 'mkdir build/pdepend'
	    sh 'vendor/bin/pdepend --jdepend-xml=build/logs/jdepend.xml --jdepend-chart=build/pdepend/dependencies.svg --overview-pyramid=build/pdepend/overview-pyramid.svg --ignore=vendor src'
	  }
    }

    stage('Generate documentation') {
	  steps {
	    sh 'vendor/bin/phpdox -f phpdox.xml'
	  }
    }

    stage('Publish Documentation') {
	  steps {
	    publishHTML (target: [
		  allowMissing: false,
		  alwaysLinkToLastBuild: false,
		  keepAll: true,
		  reportDir: 'docs/html',
		  reportFiles: 'index.html',
		  reportName: "API"
	    ])
	  }
    }

    stage('Cleanup') {
      steps {
        sh 'rm -rf silverstripe-cache'
      }
    }
  }

  post {
	  always {
	    junit 'build/logs/*.xml'
	    recordIssues enabledForFailure: true, tool: checkStyle(pattern: '**/logs/checkstyle.xml')
		recordIssues enabledForFailure: true, tool: cpd(pattern: '**/logs/pmd-cpd.xml')
	  }
  }
}