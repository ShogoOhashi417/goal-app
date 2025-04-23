import { Link, Head } from "@inertiajs/react";
import { Button } from "@/components/ui/button"
import { Card, CardContent } from "@/components/ui/card"
import { Wallet, PieChart, TrendingUp } from "lucide-react"

export default function Welcome({ auth, laravelVersion, phpVersion }) {
    return (
        <>
            <Head title="Welcome" />

            <div className="min-h-screen bg-gradient-to-b from-green-50 to-white">
                <div className="container mx-auto px-4 py-12">
                    <header className="flex justify-between items-center mb-12">
                        <div className="flex items-center gap-2">
                            <Wallet className="h-6 w-6 text-green-600" />
                            <h1 className="text-2xl font-bold text-green-800">かけいぼ</h1>
                        </div>
                    
                        <div className="flex gap-4">
                            {auth.user ? (
                                <Button className="bg-green-600 hover:bg-green-700" asChild>
                                    <Link href={route('report.balance')}>ダッシュボード</Link>
                                </Button>
                            ) : (
                                <>
                                    <Button variant="outline" asChild>
                                        <Link href={route('login')}>ログイン</Link>
                                    </Button>
                                    <Button className="bg-green-600 hover:bg-green-700" asChild>
                                        <Link href={route('register')}>新規登録</Link>
                                    </Button>
                                </>
                            )}
                        </div>
                    </header>

                    <main>
                        <section className="py-12 text-center">
                            <h2 className="text-4xl font-bold text-green-800 mb-4">シンプルで使いやすい家計簿アプリ</h2>
                            <p className="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                            日々の支出を簡単に記録し、あなたの家計をスマートに管理しましょう。
                            </p>
                            <Button size="lg" className="bg-green-600 hover:bg-green-700" asChild>
                                <Link href={route('register')}>今すぐ始める</Link>
                            </Button>
                        </section>

                        <section className="py-12">
                            <div className="grid md:grid-cols-3 gap-8">
                                <Card>
                                    <CardContent className="pt-6">
                                        <div className="text-center">
                                            <div className="bg-green-100 p-3 rounded-full inline-flex mb-4">
                                                <Wallet className="h-8 w-8 text-green-600" />
                                            </div>
                                            <h3 className="text-xl font-medium mb-2">簡単な支出記録</h3>
                                            <p className="text-gray-600">日々の支出を数タップで簡単に記録できます。</p>
                                        </div>
                                    </CardContent>
                                </Card>

                                <Card>
                                    <CardContent className="pt-6">
                                        <div className="text-center">
                                            <div className="bg-green-100 p-3 rounded-full inline-flex mb-4">
                                                <PieChart className="h-8 w-8 text-green-600" />
                                            </div>
                                            <h3 className="text-xl font-medium mb-2">わかりやすい分析</h3>
                                            <p className="text-gray-600">グラフやチャートで支出の傾向を一目で確認できます。</p>
                                        </div>
                                    </CardContent>
                                </Card>

                                <Card>
                                    <CardContent className="pt-6">
                                        <div className="text-center">
                                            <div className="bg-green-100 p-3 rounded-full inline-flex mb-4">
                                                <TrendingUp className="h-8 w-8 text-green-600" />
                                            </div>
                                            <h3 className="text-xl font-medium mb-2">目標設定と管理</h3>
                                            <p className="text-gray-600">貯金目標を設定して、達成状況を簡単に追跡できます。</p>
                                        </div>
                                    </CardContent>
                                </Card>
                            </div>
                        </section>
                    </main>

                    <footer className="text-center py-8 text-gray-600 border-t border-gray-200 mt-12">
                        <p>© 2025 かけいぼ - シンプルな家計簿アプリ</p>
                    </footer>
                </div>
            </div>

            <style>{`
                .bg-dots-darker {
                    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
                }
                @media (prefers-color-scheme: dark) {
                    .dark\\:bg-dots-lighter {
                        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
                    }
                }
            `}</style>
        </>
    );
}
