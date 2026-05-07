export type AuthUserSelf = {
	id: number;
	role: 'customer' | 'merchant';
	first_name: string;
	middle_names?: string | null;
	last_name: string;
	full_name: string;
	email: string;
	date_of_birth: string;
	user_age?: number | null;
	country: string;
	mobile_number: string;
	is_active: boolean;
};

export type AuthUserPublic = {
	id: number;
	first_name: string;
	last_name: string;
	full_name: string;
};

export type LoginResponse = {
	token: string;
	token_type: 'bearer';
	expires_at: string;
	user: {
		id: number;
		role: 'customer' | 'merchant';
		email: string;
		full_name: string;
	};
};
