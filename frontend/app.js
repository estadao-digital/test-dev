import 'core-js/es/map'
import 'core-js/es/set'
import 'raf/polyfill'

import * as React from 'react'
import { render } from 'react-dom'

import { PageContent, PageHeader } from './ui'

const rootComponent = (
  <>
    <PageHeader />
    <PageContent />
  </>
)
const rootElement = document.getElementById('app')

render(rootComponent, rootElement)
