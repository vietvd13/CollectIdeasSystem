export default {
	TOAST: {
		SUCCESS: 'Sucess',
		WARNING: 'Warning',
		DANGER: 'Danger'
	},
	ROUTER: {
		LOGIN: 'Login',
		PAGE_NOT_FOUND: 'Page Not Found',
		DASHBOARD: 'Dashboard',
		ACCOUNT_MANAGEMENT: 'Account Management',
		CATEGORY_MANAGEMENT: 'Category Management',
		DEPARTMENT: 'Department Manegement',
		IDEAS: 'Ideas Management'
	},
	NAVBAR: {
		LANGUAGE: 'Language',
		ENGLISH: 'English',
		VIETNAMESE: 'Vietnamese'
	},
	LOGIN: {
		TITLE: 'Login',
		PLACEHOLDER_ACCOUNT: 'Enter your account',
		PLACEHOLDER_PASSWORD: 'Enter your password',
		BUTTON_LOGIN: 'Login',
		LOGIN_SUCCESS: 'Successful login',
		LOGIN_ERROR: 'You have failed to login'
	},
	LOGOUT: {
		TEXT_LOGOUT: 'Logout',
		LOGOUT_SUCCESS: 'You have successfully logged out',
		LOGOUT_ERROR: 'You have failed to log out'
	},
	PAGE_NOT_FOUND: {
		DETAIL: "We can't seem to find the page you're looking for",
		GO_TO_HOME: 'Go To Home Page'
	},
	I18N: {
		CHANGE_LANGUAGE: {
			SUCCESS: 'Change language successfully.',
			FAILED: 'Language change failed.'
		}
	},
	USER: {
		TITLE: 'Account Mamangement',
		CREATE_USER: 'Create User',
		SELECT_ROLE: 'Select Role',
		FORM: {
			TITLE: 'Create User',
			PASSWORD: 'Password',
			EMAIL: 'Email',
			NAME: 'Name',
			BIRTH: 'Date of Birth',
			CREATE: 'Create',
			ROLE: 'Role',
			SUCCESS: 'Create Successfully',
			SAVE: 'SAVE',
			CLOSE: 'Close',
			DEPARTMENT: 'Department',
			AVATAR: 'Avatars',
			MESSAGE: {
				EMAIL: 'Invalid Email',
				SPACE: 'You must enter a valid value',
				PASSWORD: 'Invalid Password! Password must be at least 8 characters'
			},
			SELECT_DEPARTMENT: 'Select Department'
		},
		SEARCH_BY: {
			KEYWORD: 'Keyword',
			ROLE: 'Role',
			PLACEHOLDER_KEYWORD: 'Enter the keyword'
		},
		TABLE: {
			HEADING: {
				ID: 'ID',
				EMAIL: 'Email',
				NAME: 'Fullname',
				ROLE: 'Role',
				BIRTH: 'Date of Birth',
				ACTIONS: 'Actions',
				AVATARS: 'User Avatar'
			}
		}
	},
	CATEGORY: {
		TITLE: 'Category Management',
		CREATE_CATEGORY: 'Create category',
		SELECT_TYPE: 'Select category type',
		EDIT_CATEGORY: 'Edit category',
		FORM: {
			TITLE: 'Create category',
			CATEGORY_NAME: 'Category name',
			START_DATE: 'Start date',
			END_DATE: 'End date',
			DESCRIPTION: 'Description',
			CREATE: 'Create',
			SUCCESS: 'Create Successfully',
			SAVE: 'SAVE',
			CLOSE: 'Close',
			MESSAGE: {
				SPACE: 'You must enter a valid value'
			}
		},
		SEARCH_BY: {
			KEYWORD: 'Keyword',
			TYPE: 'Type',
			PLACEHOLDER_KEYWORD: 'Enter the keyword'
		},
		TABLE: {
			HEADING: {
				ID: 'ID',
				NAME: 'Name of categories',
				START: 'Start date',
				END: 'End date',
				DESCRIPTION: 'Description',
				ACTIONS: 'Actions',
				OWNER: 'Owner'
			}
		}
	},
	DEPARTMENT: {
		TITLE: 'Department Management',
		CREATE: 'Create Department',
		ACTIONS: {
			CREATE: 'Create a new departmetn',
			EDIT: 'Edit this department'
		},
		TABLE: {
			NAME: 'Name',
			ACTIONS: 'Actions'
		}
	},
	ROLE: {
		ADMIN: 'Admin',
		QAM: 'Quality Assurance Manager',
		QAC: 'Quality Assurance Coordinator',
		STAFF: 'Staff'
	},

	IDEA: {
		PLACEHOLDER_INPUT_IDEAD: '{name}, what are you thinking?',
		TITLE_NEW_IDEA: 'Idea',
		MESSAGE_NEW_IDEA: 'The system has just added a new idea',

		BUTTON_LIKE: 'Like',
		BUTTON_UNLIKE: 'Dislike',
		BUTTON_COMMENT: 'Comment',
		UPLOAD: {
			CONTENT: 'Content',
			ACTIONS: 'Upload your Ideas'
		},
		LICENSE: {
			TEXT: 'License',
			CONFIRM: '	I accept the terms and use.',
			CONTENT_CAT: `
			This Software Development Agreement (the “Agreement” or “Software
				Development Agreement”) states the terms and conditions that govern the
				contractual agreement between having his principal place of business at 200
				Clock Tower Pl Carmel, California(CA), 93923, (the “Developer”), and having
				its principal place of business at 200 Gainsborough Cir Folsom,
				California(CA), 95630 (the “Client”) who agrees to be bound by this
				Agreement. WHEREAS, the Client has conceptualized [QUICK DESCRIPTION OF
				SOFTWARE] (the “Software”), which is described in further detail on Exhibit
				A, and the Developer is a contractor with whom the Client has come to an
				agreement to develop the Software. NOW, THEREFORE, In consideration of the
				mutual covenants and promises made by the parties to this Software
				Development Agreement, the Developer and the Client (individually, each a
				“Party” and collectively, the “Parties”) covenant and agree as follows:`,
			DEVELOP_DUTIES: "1. Developer's duties",
			THE_CLIENT: `						The Client hereby engages the Developer and the Developer hereby agrees to
				be engaged by the Client to develop the Software in accordance with the
				specifications attached hereto as Exhibit A (the “Specifications”).`,
			THE_DEVELOPER_SHALL: `	The Developer shall complete the development of the Software
				according to the milestones described on the form attached hereto as
				Exhibit B. In accordance with such milestones, the final product
				shall be delivered to the Client by May 12 (the “Delivery Date”)..`,
			FOR_A_PERIODL: `For a period of 20 days after delivery of the final product, the
				Developer shall provide the Client attention to answer any questions
				or assist solving any problems with regard to the operation of the
				Software up to 90 of hours free of charge and billed to the Client
				at a rate of $40 per hour for any assistance thereafter. The
				Developer agrees to respond to any reasonable request for assistance
				made by the Client regarding the Software within 30 days of the
				request.`,
			EXPRESSLY_PROVIDER: `	Except as expressly provided in this Software Development Agreement,
				the Client shall not be obligated under this Agreement to provide
				any other support or assistance to the Developer.`,
			TERMINATE: `								The Client may terminate this Software Development Agreement at any
				time upon material breach of the terms herein and failure to cure
				such a breach within 20 days of notification of such a breach.`,
			DELIVERY_DATE: `								The Developer shall provide to the Client after the Delivery Date, a
				cumulative 2 days of training with respect to the operation of the
				Soft`,
			DELYVERY: '2. Delivery',
			SOFTWARE_AS_DELIVERY: `								If the Software as delivered does not conform with the
				Specifications, the Client shall within 30 days of the Delivery Date
				notify the Developer in writing of the ways in which it does not
				conform with the Specifications. The Developer agrees that upon
				receiving such notice, it shall make reasonable efforts to correct
				any non-conformity.`,
			ACCEPTANCE_DATE: `								The Client shall provide to the Developer written notice of its
				finding that the Software conforms to the Specifications within 20
				days of the Delivery Date (the “Acceptance Date”) unless it finds
				that the Software does not conform to the Specifications as
				described in Section 2(A) herein.`
		}
	},

	DASHBOARD: {
		OPTIONS: 'Select an category'
	}
};
