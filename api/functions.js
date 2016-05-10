function ContactController($scope, $http) {
    $scope.result = 'hidden'
    $scope.resultMessage;
    $scope.formData; //formData is an object holding the name, email, subject, and message
    $scope.submitButtonDisabled = false;
    $scope.submitted = false; //used so that form errors are shown only after the form has been submitted
    $scope.submit = function(contactform) {
        $scope.submitted = true;
        $scope.submitButtonDisabled = true;
        console.log($scope.formData);
        if (contactform.$valid) {
            $http({
                method  : 'POST',
                url     : 'api/contact-form.php',
                data    : $.param($scope.formData),  //param method from jQuery
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  //set the headers so angular passing info as form data (not request payload)
            }).success(function(data){
                console.log(data);
                if (data.success) { //success comes from the return json object
                    $scope.submitButtonDisabled = true;
                    $scope.resultMessage = data.message;
                    $scope.result='bg-success';
                } else {
                    $scope.submitButtonDisabled = false;
                    $scope.resultMessage = data.message;
                    $scope.result='bg-danger';
                }
            });
        } else {
            $scope.submitButtonDisabled = false;
            $scope.resultMessage = 'Failed <img src="http://www.chaosm.net/blog/wp-includes/images/smilies/icon_sad.gif" alt=":(" class="wp-smiley">  Please fill out all the fields.';
            $scope.result='bg-danger';
        }
    }
};

function CarouselCtrl($scope) {
    $scope.active = 0;
    $scope.myInterval = 3000;
    $scope.slides = [
      {image: 'img/slide-01.jpg'},
      {image: 'img/slide-02.jpg'},
      {image: 'img/slide-03.jpg'},
      {image: 'img/slide-04.jpg'}
    ];
  };

  function DonateController($scope, $http){
    $scope.result = 'hidden'
    $scope.resultMessage;
    $scope.formData; //formData is an object holding the name, email, subject, and message
    $scope.submitButtonDisabled = false;
    $scope.submitted = false; //used so that form errors are shown only after the form has been submitted
    $scope.submit = function() {
    $scope.submitted = true;
    $scope.submitButtonDisabled = true;
    console.log($scope.formData);
        $http({
            method  : 'POST',
            url     : 'http://173.9.168.170:8080/MeuTipagos/Pages/Funcoes/Crowdfunding.aspx',
            data    : $.param({
                    CpfCnpjRecebedor: 11213849000160,
                    codProduto: 57
            }),
            //data    : "CpfCnpjRecebedor=11213849000160?codProduto=57",
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  //set the headers so angular passing info as form data (not request payload)
        }).success(function(data){
            console.log(data);
        });
    }
  };
