import Footer from '../../components/Footer';
import Navbar from '../../components/Navbar';

function Home() {
    return (
        <div className="d-flex flex-column h-100">
            <Navbar />
            
            <main className="flex-shrink-0 mt-5">
                <div className="container">
                    <h1 className="mt-5">Aplicação de teste REACT</h1>
                    
                </div>
            </main>

            <Footer />
        </div>
    )
}

export default Home;