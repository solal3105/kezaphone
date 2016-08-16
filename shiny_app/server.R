set.seed(1990)
donne <- data.frame(batterie = runif(200),
                   jeux = runif(200),
                   photo = runif(200))

shinyServer(function(input, output){
 
  output$graph <- renderPlot({
   X <- donne
   score <- input$bat*X[,"batterie"] + input$jeux*X[,"jeux"] + input$Photo*X[,"photo"]
   result <- sort(score, decreasing = T)[1:3]
   names(result) <- c("Samsung X", "Infinix X", "Windows phone X")
   barplot(result, col="blue", ylab = "score", 
           ylim = c(min(result-1.5), max(result+1.5)))
   #axis(1, tick = F)
   abline(h=seq(0,30,1), col = "grey", lty = 2)
  })
  
  output$view <- renderTable({
    X <- donne
    score <- input$bat*X[,"batterie"] + input$jeux*X[,"jeux"] + input$Photo*X[,"photo"]
    result <- data.frame(
                ID = sort(score, decreasing = T, index.return = T)$ix[1:3],
                valeur = sort(score, decreasing = T, index.return = T)$x[1:3])
    
    head(result, n = 3)
  })
 })