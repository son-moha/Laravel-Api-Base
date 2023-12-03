@servers(['dev' => ['ec2-user@18.140.111.168']])

@setup
    $dir = "/home/ec2-user/matching-site-api";
    $dirSrc = "/home/ec2-user/matching-site-api/src";
@endsetup

@story('deploy')
    git
    build
@endstory

@task('git', ['on' => $server])
    cd {{ $dir }}
    pwd
    git pull
@endtask

@task('build', ['on' => $server])
    cd {{ $dir }}
    docker exec matching-site-php bash -c 'composer install'
    docker exec matching-site-php bash -c 'php artisan migrate --force'
    pwd
@endtask
