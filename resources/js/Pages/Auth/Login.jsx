import { useEffect } from 'react';
import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import { Button } from "@/components/ui/button";
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import { Wallet } from "lucide-react";

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();

        post(route('login'));
    };

    return (
        <div className="min-h-screen bg-gradient-to-b from-green-50 to-white">
            <Head title="ログイン" />

            <div className="container mx-auto px-4 py-12">
                <header className="flex justify-center items-center mb-12">
                    <div className="flex items-center gap-2">
                        <Wallet className="h-6 w-6 text-green-600" />
                        <h1 className="text-2xl font-bold text-green-800">かけいぼ</h1>
                    </div>
                </header>

                <div className="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
                    <h2 className="text-2xl font-bold text-green-800 mb-6 text-center">ログイン</h2>

                    {status && <div className="mb-6 text-sm text-green-600 bg-green-50 p-3 rounded-md">{status}</div>}

                    <form onSubmit={submit}>
                        <div className="space-y-6">
                            <div>
                                <InputLabel htmlFor="email" value="メールアドレス" className="text-gray-700" />
                                <TextInput
                                    id="email"
                                    type="email"
                                    name="email"
                                    value={data.email}
                                    className="mt-1 block w-full rounded-md border-gray-300"
                                    autoComplete="username"
                                    isFocused={true}
                                    onChange={(e) => setData('email', e.target.value)}
                                />
                                <InputError message={errors.email} className="mt-2" />
                            </div>

                            <div>
                                <InputLabel htmlFor="password" value="パスワード" className="text-gray-700" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    name="password"
                                    value={data.password}
                                    className="mt-1 block w-full rounded-md border-gray-300"
                                    autoComplete="current-password"
                                    onChange={(e) => setData('password', e.target.value)}
                                />
                                <InputError message={errors.password} className="mt-2" />
                            </div>

                            <div className="flex items-center">
                                <label className="flex items-center">
                                    <Checkbox
                                        name="remember"
                                        checked={data.remember}
                                        onChange={(e) => setData('remember', e.target.checked)}
                                        className="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500"
                                    />
                                    <span className="ms-2 text-sm text-gray-600">ログイン状態を保持する</span>
                                </label>
                            </div>

                            <div className="flex flex-col items-center gap-4">
                                <Button 
                                    className="w-full bg-green-600 hover:bg-green-700" 
                                    disabled={processing}
                                >
                                    ログイン
                                </Button>

                                <div className="flex flex-col items-center gap-2 text-sm">
                                    <Link
                                        href={route('register')}
                                        className="text-gray-600 hover:text-green-600"
                                    >
                                        アカウントをお持ちでない方はこちら
                                    </Link>

                                    {canResetPassword && (
                                        <Link
                                            href={route('password.request')}
                                            className="text-gray-600 hover:text-green-600"
                                        >
                                            パスワードをお忘れの方はこちら
                                        </Link>
                                    )}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}
