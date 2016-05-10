<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">Contato</h2>
    </div>
    <div ng-controller="ContactController" class="panel-body">
        <p ng-class="result" style="padding: 15px; margin: 0;">{{ resultMessage }}</p>
        <form ng-submit="submit(contactform)" name="contactform" method="post" action="" class="form-horizontal" role="form">
            <div class="form-group" ng-class="{ 'has-error': contactform.inputName.$invalid && submitted }">
                <label for="inputName" class="col-lg-2 control-label">Nome</label>
                <div class="col-lg-10">
                    <input ng-model="formData.inputName" type="text" class="form-control" id="inputName" name="inputName" placeholder="Seu Nome" required>
                </div>
            </div>
            <div class="form-group" ng-class="{ 'has-error': contactform.inputEmail.$invalid && submitted }">
                <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                <div class="col-lg-10">
                    <input ng-model="formData.inputEmail" type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Seu Email" required>
                </div>
            </div>
            <div class="form-group" ng-class="{ 'has-error': contactform.inputSubject.$invalid && submitted }">
                <label for="inputSubject" class="col-lg-2 control-label">Assunto</label>
                <div class="col-lg-10">
                    <input ng-model="formData.inputSubject" type="text" class="form-control" id="inputSubject" name="inputSubject" placeholder="Assunto da Mensagem" required>
                </div>
            </div>
            <div class="form-group" ng-class="{ 'has-error': contactform.inputMessage.$invalid && submitted }">
                <label for="inputMessage" class="col-lg-2 control-label">Mensagem</label>
                <div class="col-lg-10">
                    <textarea ng-model="formData.inputMessage" class="form-control" rows="4" id="inputMessage" name="inputMessage" placeholder="Sua mensagem..." required></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="submit" class="btn btn-default" ng-disabled="submitButtonDisabled">
                        Enviar
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
