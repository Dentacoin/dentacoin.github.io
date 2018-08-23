/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_FormEditor_js__ = __webpack_require__(1);
var registerBlockType = wp.blocks.registerBlockType;
var __ = wp.i18n.__;



// @TODO think about a method to magically create this list
var content_forms = ['contact', 'newsletter', 'registration'];

/**
 * Go through each form type and register a blockType from the given config
 * @TODO maybe create a custom category for OrbitFox only?
 *
 */
content_forms.forEach(function (form, index) {
	var _this = this;

	var config = window['content_forms_config_for_' + form];

	registerBlockType('content-forms/' + form, {
		title: config.title,
		icon: 'index-card',
		category: 'common',
		type: form,
		keywords: [__('forms'), __('fields')],
		edit: __WEBPACK_IMPORTED_MODULE_0__components_FormEditor_js__["a" /* ContentFormEditor */],
		// save: props => {return null}
		save: function save(props) {
			var component = _this;
			var attributes = props.attributes;
			var fields = attributes.fields;

			var fieldsEl = [];

			if (typeof attributes.uid === "undefined") {
				attributes.uid = props.id;
			}

			_.each(fields, function (args, key) {

				fieldsEl.push(wp.element.createElement('p', {
					key: key,
					className: 'content-form-field-label',
					'data-field_id': args.field_id,
					'data-label': args.label,
					'data-field_type': args.type,
					'data-requirement': args.requirement ? "true" : "false"
				}));
			});

			return wp.element.createElement(
				'div',
				{ key: 'content-form-fields', className: "content-form-fields content-form-" + form, 'data-uid': props.id },
				fieldsEl
			);
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

/***/ }),
/* 1 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ContentFormEditor; });
var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/**
 * WordPress dependencies
 */
// import { map } from 'lodash';
var Component = wp.element.Component;
var _wp$components = wp.components,
    Placeholder = _wp$components.Placeholder,
    Spinner = _wp$components.Spinner,
    withAPIData = _wp$components.withAPIData,
    FormToggle = _wp$components.FormToggle;
var __ = wp.i18n.__;
var _wp$blocks = wp.blocks,
    Editable = _wp$blocks.Editable,
    BlockEdit = _wp$blocks.BlockEdit,
    InspectorControls = _wp$blocks.InspectorControls;


var fieldStyle = {
	width: '40%',
	display: 'inline-block'
};

var fieldStyleR = {
	width: '10%',
	display: 'inline-block',
	textAlign: 'right'
};

var FormEditor = function (_Component) {
	_inherits(FormEditor, _Component);

	function FormEditor() {
		_classCallCheck(this, FormEditor);

		var _this = _possibleConstructorReturn(this, (FormEditor.__proto__ || Object.getPrototypeOf(FormEditor)).apply(this, arguments));

		_this.form_type = _this.props.name.replace('content-forms/', '');
		_this.config = window['content_forms_config_for_' + _this.form_type];
		return _this;
	}

	_createClass(FormEditor, [{
		key: 'render',
		value: function render() {
			var component = this;
			var _props = this.props,
			    attributes = _props.attributes,
			    setAttributes = _props.setAttributes,
			    focus = _props.focus;
			var fields = attributes.fields;

			var placeholderEl = wp.element.createElement(
				Placeholder,
				{ key: 'form-loader', icon: 'admin-post', label: __('Form') },
				wp.element.createElement(Spinner, null)
			);
			var controlsEl = [];
			var fieldsEl = [];

			_.each(component.config.controls, function (args, key) {

				controlsEl.push(wp.element.createElement(
					'div',
					{ key: key },
					wp.element.createElement(BlockEdit, { key: 'block-edit-custom-' + key }),
					wp.element.createElement(InspectorControls.TextControl, {
						key: key,
						label: args.label,
						value: attributes[key] || '',
						onFocus: function onFocus(f) {
							console.log(f);
						},
						onChange: function onChange(value) {
							var newValues = {};
							newValues[key] = value;
							setAttributes(newValues);
						}
					})
				));
			});

			_.each(fields, function (args, key) {
				var val = '';
				var field_id = args.field_id;
				var field_config = component.config.fields[field_id];
				var isRequired = false;

				if (_typeof(args.label) === "object") {
					val = args.label[0];
				} else if (typeof args.label === "string") {
					val = [args.label];
				}

				if (typeof args.requirement !== "undefined") {
					isRequired = args.requirement;
				}

				var focusOn = 'field-' + field_id;

				fieldsEl.push(wp.element.createElement(
					'div',
					{ key: key, style: { border: '1px solid #333', padding: '5px', margin: '5px', borderRadius: '8px' }, className: 'content-form-field' },
					wp.element.createElement(
						'fieldset',
						{ style: fieldStyle },
						wp.element.createElement(Editable, {
							value: val,
							tagName: 'label',
							placeholder: __('Label for ') + field_id,
							className: 'content-form-field-label',
							onChange: function onChange(value) {
								var newValues = attributes.fields;
								newValues[key]['label'] = value;
								setAttributes({ fields: newValues });
								component.forceUpdate();
							} })
					),
					wp.element.createElement(
						'fieldset',
						{ style: fieldStyle },
						wp.element.createElement(
							'select',
							{
								name: 'field-type-select',
								value: typeof args['type'] !== "undefined" ? args['type'] : 'text',
								onChange: function onChange(event) {
									var newValues = attributes.fields;
									newValues[key]['type'] = event.target.selected;
									setAttributes({ fields: newValues });
									component.forceUpdate();
								} },
							wp.element.createElement(
								'option',
								{ value: 'text', key: 'text' },
								'text'
							),
							wp.element.createElement(
								'option',
								{ value: 'textarea', key: 'textarea' },
								'textarea'
							),
							wp.element.createElement(
								'option',
								{ value: 'password', key: 'password' },
								'password'
							),
							wp.element.createElement(
								'option',
								{ value: 'email', key: 'email' },
								'email'
							),
							wp.element.createElement(
								'option',
								{ value: 'number', key: 'number' },
								'number'
							)
						)
					),
					wp.element.createElement(
						'fieldset',
						{ style: fieldStyleR },
						wp.element.createElement(FormToggle, {
							checked: isRequired,
							showHint: false,
							onChange: function onChange(event) {
								var newValues = attributes.fields;
								newValues[key]['requirement'] = event.target.checked;
								setAttributes({ fields: newValues });
								component.forceUpdate();
							}
						})
					)
				));
			});

			return [focus && wp.element.createElement(
				InspectorControls,
				{ key: 'inspector' },
				wp.element.createElement(
					'h3',
					null,
					__('Form Settings')
				),
				controlsEl
			), wp.element.createElement(
				'div',
				{ key: 'fields', className: 'fields ' + component.props.className, 'data-uid': attributes.uid },
				fieldsEl === [] ? placeholderEl : fieldsEl
			)];
		}
	}]);

	return FormEditor;
}(Component);

var ContentFormEditor = withAPIData(function () {
	return {
		ContentForm: '/content-forms/v1/forms'
	};
})(FormEditor);

/***/ })
/******/ ]);