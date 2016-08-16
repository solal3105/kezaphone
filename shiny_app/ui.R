library(shiny)

fluidPage({
  sidebarLayout(
    sidebarPanel(
      sliderInput("bat", "Importance de la batterie", min=0, max=10, value=5,
                  step=1),
      sliderInput("jeux", "Qualite de jeux", min=0, max=10, value=5,
                  step=1),
      sliderInput("Photo", "Qualite photo", min=0, max=10, value=5,
                  step=1)
                ),
    
                mainPanel(
                  tabsetPanel(type = 'tabs',
                              tabPanel('ID',tableOutput("view")),
                              tabPanel('Graphic',plotOutput("graph")))
              ))
  
})