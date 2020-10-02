import React from 'react';

import Header from '../components/Header';

interface LayoutProps {
  children: React.ReactNode | React.ReactElement;
}

const Layout: React.FC<LayoutProps> = ({ children }: LayoutProps) => {
  return (
    <>
      <Header />
      {children}
    </>
  );
};

export default Layout;
