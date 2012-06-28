namespace :test do
  desc "Run the test suite with test"
  task :run do
    system "phpunit"
  end

  desc "Generate coverage report"
  task :coverage do
    system "phpunit --coverage-html=coverage"
  end
end
