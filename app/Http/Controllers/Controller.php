<?php

namespace App\Http\Controllers;

abstract class Controller
{
	/**
	 * VALIDATION CHEATSHEET
	 * 
	 * Validate the incoming requests.
	 * Validation will fail if the incoming request includes any fields that are not
	 * included in this list.
	 * 
	 * Order matters!
	 * 
	 * 1. Presence:
	 * 
	 * 		'required'		=> Field must be present and not empty
	 * 							e.g, 'name' => ['required', 'string']
	 * 
	 * 		'sometimes'		=> Validate field only if it's present
	 * 							e.g, 'phone' => ['sometimes', 'string']
	 * 
	 * 		'nullable'		=> Field may be present but may also be null or empty
	 * 							e.g, 'middle_name' => ['nullable', 'string']
	 * 
	 * 		'filled'		=> Field must be present and not empty (like required but doesn't fail on false/0)
	 * 							e.g, 'is_active' => ['filled', 'boolean']
	 * 
	 * 		'present'		=> Field must be present but can be empty
	 * 							e.g, 'notes' => ['present', 'string']
	 * 
	 * 		'required_if:field,value,...'
	 * 							e.g, 'payment_method' => ['required_if:type,online', 'string']
	 * 
	 * 		'required_unless:field,value,...'
	 *							e.g, 'country' => ['required_unless:shipping_method,digital', 'string']
	 * 
	 * 		'required_with:field1,field2,...'
	 * 							e.g, 'card_cvv' => ['required_with:card_number', 'string']
	 * 
	 * 		'required_with_all:field1,field2,...'
	 * 							e.g, 'shipping_address' => ['required_with_all:physical_product,delivery_method', 'string']
	 * 
	 * 		'required_without:field1,field2,...'
	 * 							e.g, 'email' => ['required_without:phone', 'email']
	 * 
	 * 		'required_without_all:field1,field2,...'
	 * 							e.g, 'contact_method' => ['required_without_all:email,phone,address',]
	 * 
	 * 
	 * 2. Data Type:
	 * 
	 * 		'string'		=> Must be a string
	 * 							e.g, 'name' => ['required', 'string']
	 * 
	 * 		'array'			=> Must be an array
	 * 							e.g, 'tags' => ['sometimes', 'array']
	 * 
	 * 		'integer'		=> Must be an integer
	 * 							e.g, 'age' => ['sometimes', 'integer']
	 * 
	 * 		'numeric'		=> Must be numeric (integer or float)
	 * 							e.g, 'price' => ['required', 'numeric']
	 * 
	 * 		'boolean'		=> Must be boolean (true, false, 1, 0, "1", "0")
	 * 							e.g, 'active' => ['sometimes', 'boolean']
	 * 
	 * 		'file'			=> Must be an uploaded file
	 * 							e.g, 'avatar' => ['sometimes', 'file']
	 * 
	 * 		'image'			=> Must be an image file (jpeg, png, bmp, gif, svg, webp)
	 * 							e.g, 'photo' => ['sometimes', 'image']
	 * 
	 * 
	 * 3. Formats:
	 * 
	 * 		'email'			=> Must be a valid email format
	 * 							e.g, 'email' => ['required', 'email']
	 * 
	 * 		'url'			=> Must be a valid URL
	 * 							e.g, 'website' => ['sometimes', 'url']
	 * 
	 * 		'ip'			=> Must be a valid IP address
	 * 							e.g, 'ip_address' => ['sometimes', 'ip']
	 * 
	 * 		'ipv4'			=> Must be a valid IPv4 address
	 * 							e.g, 'ipv4' => ['sometimes', 'ipv4']
	 * 
	 * 		'ipv6'			=> Must be a valid IPv6 address
	 * 							e.g, 'ipv6' => ['sometimes', 'ipv6']
	 * 
	 * 		'json'			=> Must be a valid JSON string
	 * 							e.g, 'preferences' => ['sometimes', 'json']
	 * 
	 * 		'date'			=> Must be a valid date
	 * 							e.g, 'birthday' => ['sometimes', 'date']
	 * 
	 * 		'date_format:format' => Must match a specific date formate
	 * 							e.g, 'expiry' => ['sometimes', 'date_format:Y-m-d']
	 * 
	 * 		'uuid'			=> Must be a valid UUID
	 * 							e.g, 'id' => ['required', 'uuid']
	 * 
	 * 		'regex:pattern'	=> Must match the regular expression pattern
	 * 							e.g, 'username' => ['regex:/^[a-z0-9_]+$/']
	 * 
	 *		'mimetypes:text/plain,...' => Must match one of the given MIME types
	 * 							e.g, 'document' => ['sometimes', 'mimetypes:text/plain,application/pdf']
	 * 
	 * 		'mimes:jpg,pdf'	=> Must have one of the given extensions (simplified MIME check)
	 * 							e.g, 'file' => ['sometimes', 'mimes:jpg,png,pdf']
	 * 
	 * 
	 * 4. Constraints
	 * 
	 * 		'accepted'		=> Must be "yes", "on", "1", or true
	 * 							e.g, 'terms' => ['accepted']
	 * 
	 * 		'declined'		=> Must be "no", "off", "0", or false
	 * 							e.g, 'newsletter' => ['declined']
	 * 
	 * 		'digits:n'		=> Must be numeric and have exactly n digits
	 * 							e.g, 'zip_code' => ['sometimes', 'digits:5']
	 * 
	 * 		'digits_between:min,max' => Must be numeric and have digits between min and max
	 * 							e.g, 'phone' => ['sometimes', 'digits_between:10,15']
	 * 
	 * 		'min:value'		=> Minimum value/length
	 * 							e.g, 'age'  => ['integer', 'min:18']
	 * 								 'name' => ['string',  'min:2' ]
	 * 
	 * 		'max:value'		=> Maximum value/length
	 * 							e.g, 'title' => ['string', 'max:255']
	 * 
	 * 		'between:min,man' => Value between min and max (inclusive)
	 * 							e.g, 'score' => ['integer', 'between:1,100']
	 * 
	 * 		'size:value'	=> Exact size/length
	 * 							e.g, 'pin' => ['digits:4', 'size:4'] // Exactly 4 digits
	 * 
	 * 		'gt:field'		=> Greater than another field in the request
	 * 							e.g, 'end_date' => ['date', 'gt:start_date']
	 * 
	 * 		'gte:field'		=> Greater than or equal to another field in the request
	 * 							e.g, 'retail_price' => ['numeric', 'gte:wholesale_price']
	 * 
	 * 		'lt:field'		=> Less than another field in the request
	 * 							e.g, 'child_age' => ['integer', 'lt:parent_age']
	 * 
	 * 		'lte:field'		=> Less than or equal to another field in the request
	 * 							e.g, 'discount' => ['numeric', 'lte:original_price']
	 * 
	 * 		'in:value1,value2' => Must be one of the given values
	 * 							e.g, 'status' => ['in:active,inactive,pending']
	 * 
	 * 		'not_in:value1,value2' => Must not be one of the given values
	 * 							e.g, 'role' => ['not_in:admin,superadmin']
	 * 
	 * 		'dimensions:mw,mh' => Image dimension constraints
	 * 							e.g, 'avatar' => ['image', 'dimensions:min_width=100,min_height=100']
	 * 
	 * 		'max:kilobytes'	=> For files
	 * 							e.g, 'upload' => ['file', 'max:2048']
	 * 
	 * 		'after:date'	=> Must be after the given date
	 * 							e.g, 'start_date' => ['date', 'after:today']
	 * 
	 * 		'after_or_equal:date' => Must be after or equal to the given date
	 * 							e.g, 'event_date' => ['date', 'after_or_equal:2020-03-01']
	 * 		
	 * 		'before:date'	=> Must be before the given date
	 * 							e.g, 'expiry_date' => ['date', 'before:2025-01-01']
	 * 
	 * 		'before_or_equal:date' => Must be before or equal to the given date
	 * 							e.g, 'birth_date' => ['date', 'before_or_equal:today']
	 * 
	 * 		'distinct'		=> Array values must be unique
	 * 							e.g, 'tags' => ['array', 'distinct']
	 * 
	 * 		'min:length'	=> Minimum number of array items
	 * 							e.g, 'categories' => ['array', 'min:1']
	 * 
	 * 		'max:length'	=> Maximum number of array items
	 * 							e.g, 'attachments' => ['array', 'max:5']
	 * 
	 * 
	 * 5. Database 
	 * 
	 *		'exist:table,column' => Must exist in the given database table
	 * 							e.g, 'user_id' => ['required', 'exists:users,id']
	 * 
	 * 		'unique:table,column' => Must not exist in the given database table
	 * 							e.g, 'email' => ['required', 'unique:users,email']
	 * 
	 */
}
