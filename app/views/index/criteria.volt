<div class="row-fluid">
	<h1 class="text-center">Criteria en Phalcon</h1><hr><br>
	<div class="col-md-8 col-md-offset-2">
		{{ form('index/criteria', 'method': 'post') }}
	 
			<div class="form-group col-sm-2">
				<label>Por Id</label>
				{{ text_field("id", "class": "form-control") }}
			</div>
		 
			<div class="form-group col-sm-3">
				<label>Por título</label>
				{{ text_field("title", "class": "form-control") }}
			</div>
		 
			<div class="form-group col-sm-3">
				<label>Por contenido del post</label>
				{{ text_field("content", "class": "form-control") }}
			</div>
		 
			<div class="form-group col-sm-4">
				<label>Por fecha</label>
				{{ date_field("created_at", "value": "18-04-2014", "class":"form-control") }}
			</div>

			{{ submit_button('Buscar', "class": "btn btn-success pull-right") }}
		</form>
	</div>
	<div class="col-md-8 col-md-offset-2">
		<?php if(is_object($posts) && !empty($posts)): ?>
		<h2 style="margin-top: 40px">Resultados de la búsqueda</h2>
		<table class="table">
			<thead>
				<tr>
					<th>Título</th>
					<th>Contenido</th>
					<th>Fecha</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach($posts as $post): ?>
				<tr>
					<td><?php echo $post->title ?></td>
					<td><?php echo $post->content ?></td>
					<td><?php echo $post->created_at ?></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
		<?php endif ?>
	</div>
</div>