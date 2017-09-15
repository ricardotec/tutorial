<div class="well row">
	{{ content() }}
    {{ form('class': 'form-login') }}
	    <div class="span6 offset4">
	        <h2>Acceso al sistema</h2>
	    </div>
	    <div class="span6 offset4">
			{{ form.label('login') }}
	        {{ form.render('login') }}
	    </div>
	    <div class="span6 offset4">
	        {{ form.label('password') }}
	        {{ form.render('password') }}
	    </div>
	    <div class="span2 offset4" align="center">
            {{ form.render('Entrar') }}
        </div>
    </form>
</div>