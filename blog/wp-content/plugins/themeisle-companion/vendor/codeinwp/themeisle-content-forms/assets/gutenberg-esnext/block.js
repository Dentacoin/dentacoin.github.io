const {
	registerBlockType,
} = wp.blocks;
const { __ } = wp.i18n;
import { ContentFormEditor } from './components/FormEditor.js'

// @TODO think about a method to magically create this list
const content_forms = [
	'contact',
	'newsletter',
	'registration'
];

/**
 * Go through each form type and register a blockType from the given config
 * @TODO maybe create a custom category for OrbitFox only?
 *
 */
content_forms.forEach(function (form, index) {
	let config = window['content_forms_config_for_' + form];

	registerBlockType('content-forms/' + form, {
		title: config.title,
		icon: 'index-card',
		category: 'common',
		type: form,
		keywords: [ __( 'forms' ), __( 'fields' ) ],
		edit: ContentFormEditor,
		// save: props => {return null}
		save: props => {
			const component = this
			const {attributes} = props
			const {fields} = attributes
			let fieldsEl = []

			if ( typeof attributes.uid === "undefined" ) {
				attributes.uid = props.id
			}

			_.each(fields, function (args, key) {

				fieldsEl.push(<p
						key={key}
						className="content-form-field-label"
						data-field_id={args.field_id}
						data-label={args.label}
						data-field_type={args.type}
						data-requirement={args.requirement ? "true": "false"}
					/>)
			})

			return (<div key="content-form-fields" className={"content-form-fields content-form-" + form} data-uid={props.id}>
				{fieldsEl}
			</div>)
		}

		// @TODO Maybe return to the old way of saving a plain html
		// save: props => {
		// 	const {
		// 		className,
		// 		attributes
		// 	} = props;
		//
		// 	let elements = [];
		//
		// 	_.each(config.fields, function (args, key) {
		// 		let fieldset_element = <fieldset key={key}>
		// 			<label htmlFor={key}>{attributes[key]}</label>
		// 			<input type="text" name={key} />
		// 		</fieldset>;
		// 		elements.push(fieldset_element)
		// 	});
		//
		// 	// Add a submit button; @TODO Make a setting for this;
		// 	elements.push(<button key="submit_btn">Submit</button>);
		//
		// 	return (
		// 		<form className={ props.className } method="post" action={submitAction}>
		// 			{elements}
		// 		</form>
		// 	);
		// }
	});
});

