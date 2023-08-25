<style>
	.navbar, #footer {
		z-index: 4;
	}

	#login .login-main {
		z-index: 2;
	}

	#login .login-main form .form-control {
		border-radius: .25rem;
	}

	@media (min-width: 992px) {
		#login .login-banner {
			border-radius: 0 20px 20px 0;
		}
	}


	/*RATING*/

	.rating-container > input {
		display: none;
	}

	/* Remove radio buttons */

	.rating-container > label:before {
		content: "\f005"; /* Star */
		margin: 2px;
		font-size: 2em;
		font-family: FontAwesome;
		display: inline-block;
	}

	.rating-container > label {
		color: #222222; /* Start color when not clicked */
	}

	.rating-container > input:checked ~ label {
		color: #ffca08;
	}

	/* Set yellow color when star checked */

	.rating-container > input:hover ~ label {
		color: #ffca08;
	}

	/* Set yellow color when star hover */


</style>
