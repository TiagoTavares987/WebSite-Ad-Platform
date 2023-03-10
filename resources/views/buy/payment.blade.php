@extends('layouts.app')

@section('content')
<head>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<body>
<div class="container">

    <div class="row">

        <div class="col-md-6 col-md-offset-3">

            <div class="panel panel-default credit-card-box">

                <div class="panel-heading display-table" >

                        <h3 class="panel-title" >{{ __('Pagamento') }}</h3>

                </div>

                <div class="panel-body">

    

                    @if (Session::has('success'))

                        <div class="alert alert-success text-center">

                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>

                            <p>{{ Session::get('success') }}</p>

                        </div>

                    @endif

    

                    <form 

                            role="form" 

                            action="{{ route('buy') }}" 

                            method="post" 

                            class="require-validation"

                            data-cc-on-file="false"

                            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"

                            id="payment-form">

                        @csrf

                        <input name="adId" type="hidden" value="{{ $buy->anuncioId }}"/>
                        <input name="price" type="hidden" value="{{ $buy->preco }}"/>
                        <input name="quantity" type="hidden" size="4" value="{{ $buy->quantidade }}"/> 

                        <div class='form-row row'>

                            <div class='col-xs-12 form-group required'>

<<<<<<< HEAD
                                <label class='control-label'>Name on Card</label> <input
=======
                                <label class='control-label'>Nome do Cartão</label> <input
>>>>>>> a13c9e55b364bfc48f7777951bf70960f4c8b59c

                                    class='form-control' size='4' type='text'>

                            </div>

                        </div>

    

                        <div class='form-row row'>

                            <div class='col-xs-12 form-group card required'>

<<<<<<< HEAD
                                <label class='control-label'>Card Number</label> <input
=======
                                <label class='control-label'>Numero do Cartão</label> <input
>>>>>>> a13c9e55b364bfc48f7777951bf70960f4c8b59c

                                    autocomplete='off' class='form-control card-number' size='20'

                                    type='text'>

                            </div>

                        </div>

    

                        <div class='form-row row'>

                            <div class='col-xs-12 col-md-4 form-group cvc required'>

                                <label class='control-label'>CVC</label> <input autocomplete='off'

                                    class='form-control card-cvc' placeholder='ex. 311' size='4'

                                    type='text'>

                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>

<<<<<<< HEAD
                                <label class='control-label'>Expiration Month</label> <input
=======
                                <label class='control-label'>Mês de Expiração</label> <input
>>>>>>> a13c9e55b364bfc48f7777951bf70960f4c8b59c

                                    class='form-control card-expiry-month' placeholder='MM' size='2'

                                    type='text'>

                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>

<<<<<<< HEAD
                                <label class='control-label'>Expiration Year</label> <input
=======
                                <label class='control-label'>Ano de Expiração</label> <input
>>>>>>> a13c9e55b364bfc48f7777951bf70960f4c8b59c

                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'

                                    type='text'>

                            </div>

                        </div>

    

                        <div class='form-row row'>

                            <div class='col-md-12 error form-group hide'>

<<<<<<< HEAD
                                <div class='alert-danger alert'>Please correct the errors and try

                                    again.</div>
=======
                                <div class='alert-danger alert'>Por Favor corriga os erros e tenta novamente.

                                </div>
>>>>>>> a13c9e55b364bfc48f7777951bf70960f4c8b59c

                            </div>

                        </div>

    

                        <div class="row">

                            <div class="col-xs-12">

<<<<<<< HEAD
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now ({{ $buy->preco }} €)</button>
=======
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pagar Agora ({{ $buy->preco }}€)</button>
>>>>>>> a13c9e55b364bfc48f7777951bf70960f4c8b59c

                            </div>

                        </div>

                            

                    </form>

                </div>

            </div>        

        </div>

    </div>

        

</div>
</body>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
$(function() {
    /*------------------------------------------
    --------------------------------------------
    Stripe Payment Code
    --------------------------------------------
    --------------------------------------------*/    

    var $form = $(".require-validation");     

    $('form.require-validation').bind('submit', function(e) {

        var $form = $(".require-validation"),

        inputSelector = ['input[type=email]', 'input[type=password]',

                         'input[type=text]', 'input[type=file]',

                         'textarea'].join(', '),

        $inputs = $form.find('.required').find(inputSelector),

        $errorMessage = $form.find('div.error'),

        valid = true;

        $errorMessage.addClass('hide');    

        $('.has-error').removeClass('has-error');

        $inputs.each(function(i, el) {

          var $input = $(el);

          if ($input.val() === '') {

            $input.parent().addClass('has-error');

            $errorMessage.removeClass('hide');

            e.preventDefault();

          }

        });     

        if (!$form.data('cc-on-file')) {

          e.preventDefault();

          Stripe.setPublishableKey($form.data('stripe-publishable-key'));

          Stripe.createToken({

            number: $('.card-number').val(),

            cvc: $('.card-cvc').val(),

            exp_month: $('.card-expiry-month').val(),

            exp_year: $('.card-expiry-year').val()

          }, stripeResponseHandler);
        }
    });      

    /*------------------------------------------
    --------------------------------------------
    Stripe Response Handler
    --------------------------------------------
    --------------------------------------------*/

    function stripeResponseHandler(status, response) {

        if (response.error) {

            $('.error')

                .removeClass('hide')

                .find('.alert')

                .text(response.error.message);

        } else {

            /* token contains id, last4, and card type */

            var token = response['id'];                 

            $form.find('input[type=text]').empty();

            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");

            $form.get(0).submit();
        }
    }
});

</script>
@endsection
