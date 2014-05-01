version     = ENV['VERSION']
destination = "tmp/dist/#{version}"

namespace :git do
  desc "Update .gitignore"
  task :ignore do
    cp 'lib/templates/gitignore', '.gitignore'
    sh 'git add .gitignore'
    sh 'git commit -m "Updates .gitignore"'
  end

  task :vendor do
    sh 'git add vendor'
    sh 'git commit -m "Adds vendor"'
  end

  task :clean do
    sh 'rm -rf tmp'              if File.directory?('tmp')
    sh 'rm -rf bower_components' if File.directory?('bower_components')
    sh 'rm wp-cli.local.yml'     if File.exists?('wp-cli.local.yml')

    sh 'git rm *.json'
    sh 'git rm *.lock'
    sh 'git rm -r test'
    sh 'git rm -r bin'
    sh 'git rm phpunit.xml'
    sh 'git rm Gemfile'
    sh 'git rm Rakefile'

    sh 'git commit -m "Removes development files"'
  end

  task :clear_after do
    sh 'git rm -r lib/templates' if File.directory?('lib/templates')
    sh 'git commit -m "Cleaning up after dist"'
  end

  # todo: conditionally add js libs
  task :js do
  end

  task :archive do
    sh "rm -rf #{destination}" if File.directory?(destination)
    mkdir_p destination
    sh "git archive dist-#{version} --format tar | (cd tmp/dist/#{version} && tar xf -)"
  end

  task :branch do
    sh "git checkout -b dist-#{version}"
  end
end

namespace :bower do
  desc "Copy Bower libraries"
  task :copy do
    cp 'bower_components/scrollUp/js/jQuery.scrollUp.js', 'js/jquery-scroll-up.js'
  end

  desc "Update Bower libraries"
  task :update do
    sh 'bower update'
  end
end

namespace :composer do
  desc "Update Composer dependencies"
  task :update do
    sh 'rm -rf vendor' if File.directory?('vendor')
    sh 'composer update'

    # todo: use porcelain if this isn't good enough
    changed = `git status`
    if !changed.include?('working directory clean')
      sh 'git add composer.json composer.lock'
      sh 'git commit -m "Fresh composer update"'
    end
  end
end

namespace :svn do
  desc "Copy files to svn trunk"
  task :copy do
    sh "rsync -av tmp/dist/#{version}/ ../svn/trunk --exclude=.gitignore"
  end

  desc "Add changed files to svn"
  task :add do
    Dir.chdir('../svn') do
      sh "svn add . --force"
    end
  end

  desc "Commit changed files to svn"
  task :commit do
    Dir.chdir('../svn/trunk') do
      sh "svn commit -m 'Release #{version}'"
    end
  end

  desc "Create release tag"
  task :tag do
    Dir.chdir('../svn') do
      repo  = "http://plugins.svn.wordpress.org/whats-my-ip"
      trunk = "#{repo}/trunk"
      tag   = "#{repo}/tags/#{version}"

      sh "svn copy #{trunk} #{tag} -m 'Release Tag: #{version}'"
    end
  end
end

desc 'Create a new Distribution'
task :dist => [
  'git:branch',
  'composer:update',
  'git:clean',
  'git:ignore',
  'git:vendor',
  'git:clear_after'
]

desc 'Initialize - after distribution'
task :init => [
  'composer:update',
  'bower:update'
]

desc 'Publish to wordpress.org'
task :publish => [
  'git:archive',
  'svn:copy',
  'svn:add',
  'svn:commit',
  'svn:tag'
]
