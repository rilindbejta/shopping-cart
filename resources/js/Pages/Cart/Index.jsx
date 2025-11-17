import { Head, Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { useState } from 'react';
import PrimaryButton from '@/Components/PrimaryButton';
import DangerButton from '@/Components/DangerButton';

export default function Index({ cartItems, total }) {
    const [updatingItem, setUpdatingItem] = useState(null);
    const [deletingItem, setDeletingItem] = useState(null);
    const [isCheckingOut, setIsCheckingOut] = useState(false);

    const handleUpdateQuantity = (cartId, newQuantity) => {
        if (newQuantity < 1) return;
        
        setUpdatingItem(cartId);
        
        router.patch(route('cart.update', cartId), {
            quantity: newQuantity,
        }, {
            preserveScroll: true,
            onFinish: () => setUpdatingItem(null),
        });
    };

    const handleRemoveItem = (cartId) => {
        if (!confirm('Are you sure you want to remove this item from your cart?')) {
            return;
        }

        setDeletingItem(cartId);
        
        router.delete(route('cart.destroy', cartId), {
            preserveScroll: true,
            onFinish: () => setDeletingItem(null),
        });
    };

    const handleCheckout = () => {
        if (!confirm('Proceed with checkout?')) {
            return;
        }

        setIsCheckingOut(true);
        
        router.post(route('orders.checkout'), {}, {
            onFinish: () => setIsCheckingOut(false),
        });
    };

    return (
        <AuthenticatedLayout
            header={
                <div className="flex justify-between items-center">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        Shopping Cart
                    </h2>
                    <div className="flex gap-4">
                        <Link
                            href={route('products.index')}
                            className="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 dark:border-gray-500 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800"
                        >
                            Continue Shopping
                        </Link>
                        <Link
                            href={route('orders.index')}
                            className="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 dark:border-gray-500 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800"
                        >
                            View Orders
                        </Link>
                    </div>
                </div>
            }
        >
            <Head title="Shopping Cart" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {cartItems.length === 0 ? (
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                            <div className="p-6 text-center text-gray-900 dark:text-gray-100">
                                <h3 className="mb-4 text-lg font-semibold">Your cart is empty</h3>
                                <Link
                                    href={route('products.index')}
                                    className="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                >
                                    Start shopping →
                                </Link>
                            </div>
                        </div>
                    ) : (
                        <div className="grid gap-6 lg:grid-cols-3">
                            <div className="lg:col-span-2 space-y-4">
                                {cartItems.map((item) => (
                                    <div
                                        key={item.id}
                                        className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                                    >
                                        <div className="p-6">
                                            <div className="flex items-start justify-between">
                                                <div className="flex-1">
                                                    <h3 className="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                        {item.product.name}
                                                    </h3>
                                                    <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                        ${item.product.price} each
                                                    </p>
                                                    <p className="mt-1 text-xs text-gray-500 dark:text-gray-500">
                                                        {item.product.stock_quantity} available
                                                    </p>
                                                </div>

                                                <div className="ml-4 text-right">
                                                    <p className="text-lg font-bold text-gray-900 dark:text-gray-100">
                                                        ${item.subtotal}
                                                    </p>
                                                </div>
                                            </div>

                                            <div className="mt-4 flex items-center justify-between">
                                                <div className="flex items-center gap-2">
                                                    <button
                                                        onClick={() => handleUpdateQuantity(item.id, item.quantity - 1)}
                                                        disabled={updatingItem === item.id || item.quantity <= 1}
                                                        className="rounded-md bg-gray-200 px-3 py-1 text-sm font-semibold text-gray-700 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                                                    >
                                                        -
                                                    </button>
                                                    <span className="min-w-[3rem] text-center text-gray-900 dark:text-gray-100">
                                                        {item.quantity}
                                                    </span>
                                                    <button
                                                        onClick={() => handleUpdateQuantity(item.id, item.quantity + 1)}
                                                        disabled={
                                                            updatingItem === item.id ||
                                                            item.quantity >= item.product.stock_quantity
                                                        }
                                                        className="rounded-md bg-gray-200 px-3 py-1 text-sm font-semibold text-gray-700 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                                                    >
                                                        +
                                                    </button>
                                                </div>

                                                <button
                                                    onClick={() => handleRemoveItem(item.id)}
                                                    disabled={deletingItem === item.id}
                                                    className="text-sm text-red-600 hover:text-red-900 disabled:opacity-50 dark:text-red-400 dark:hover:text-red-300"
                                                >
                                                    {deletingItem === item.id ? 'Removing...' : 'Remove'}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>

                            <div className="lg:col-span-1">
                                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 sticky top-4">
                                    <div className="p-6">
                                        <h3 className="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            Order Summary
                                        </h3>

                                        <div className="mt-4 space-y-2">
                                            <div className="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                                <span>Items ({cartItems.length})</span>
                                                <span>${total}</span>
                                            </div>
                                        </div>

                                        <div className="mt-4 border-t border-gray-200 pt-4 dark:border-gray-700">
                                            <div className="flex justify-between text-lg font-bold text-gray-900 dark:text-gray-100">
                                                <span>Total</span>
                                                <span>${total}</span>
                                            </div>
                                        </div>

                                        <div className="mt-6">
                                            <PrimaryButton
                                                className="w-full justify-center"
                                                onClick={handleCheckout}
                                                disabled={isCheckingOut}
                                            >
                                                {isCheckingOut ? 'Processing...' : 'Proceed to Checkout'}
                                            </PrimaryButton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

