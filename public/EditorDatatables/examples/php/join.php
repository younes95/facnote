<?php

// DataTables PHP library
include( "../../php/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;

$token = $_GET['token'];


/*
 * Example PHP implementation used for the join.html example
 */
Editor::inst( $db, 'ecriture' )
	->field( 
		Field::inst( 'ecriture.date_ecriture' ),
		Field::inst( 'ecriture.libelle_ecriture' ),
		Field::inst( 'ecriture.num_compte_ecriture' ),
		Field::inst( 'ecriture.debit_ecriture' ),
		Field::inst( 'ecriture.credit_ecriture' ),

		Field::inst( 'ecriture.id_journal_id' )
			->options( Options::inst()
				->table( 'journal' )
				->value( 'id' )
				->label( 'libelle_journal' )
			)
			->validator( Validate::dbValues() ),
		Field::inst( 'journal.libelle_journal' ),

		Field::inst( 'ecriture.id_societe_id' )
			->options( Options::inst()
				->table( 'societe' )
				->value( 'id' )
				->label( 'raison_social' )
			)
			->validator( Validate::dbValues() ),
		Field::inst( 'societe.raison_social' ),

		Field::inst( 'ecriture.id_exercice_id' )
			->options( Options::inst()
				->table( 'exercice' )
				->value( 'id' )
				->label( 'libelle_exercice' )
			)
			->validator( Validate::dbValues() ),
		Field::inst( 'exercice.libelle_exercice' )

	)
	->leftJoin( 'journal', 'journal.id', '=', 'ecriture.id_journal_id' )
	->leftJoin( 'exercice', 'exercice.id', '=', 'ecriture.id_exercice_id' )
	->leftJoin( 'societe', 'societe.id', '=', 'ecriture.id_societe_id' )
	->where( 'societe.token_societe', $token )
	->process($_POST)
	->json();
