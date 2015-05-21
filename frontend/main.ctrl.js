angular.module('app').controller('MainController', function(){
    var vm = this;
    vm.title = 'Jean Carlo Machado'

    vm.posts = [
        {
            title: 'Post1',
            date: '2010-11-30',
            description: 'Lorem ipsum',
        },
        {
            title: 'Post1',
            date: '2010-11-30',
            description: 'Lorem ipsum',
        }
    ];
});
