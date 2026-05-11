import { loadStripe, type Stripe } from '@stripe/stripe-js';

/**
 * Loads Stripe.js with the publishable key from `NUXT_PUBLIC_STRIPE_PUBLISHABLE_KEY`.
 */
export async function useStripeClient(): Promise<Stripe | null> {
	const config = useRuntimeConfig();
	const pk = String(config.public.stripePublishableKey ?? '').trim();
	if (!pk) {
		return null;
	}

	return loadStripe(pk);
}
