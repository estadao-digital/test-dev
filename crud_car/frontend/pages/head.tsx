import Head from 'next/head'

function CustomHead(title: string) {
    return (
        <Head>
            <title>{`${title}`}</title>
            <meta name="description" content="Teste para o estadão" />
            <link rel="icon" href="/favicon.svg" />
        </Head>
    )
}

export default CustomHead;